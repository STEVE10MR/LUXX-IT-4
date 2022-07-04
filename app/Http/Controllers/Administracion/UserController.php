<?php

namespace App\Http\Controllers\Administracion;

use Carbon\Carbon;
use App\Models\User;
use App\Mail\Password;
use App\Models\Products;
use App\Mail\Verification;
use App\Models\Email_verify;
use Illuminate\Http\Request;
use App\Http\Requests\SaveFormUser;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('admin')->except(['management','edit_profile','update_profile']);
    }
    public function index(Request $request){
        $busqueda=$request->get('search')?$request->get('search'):'';
        $user=User::select('id','name', 'email','phone','status','created_at','updated_at')->orderBy('created_at',request('sorted','ASC'))->Where('role','=','REPA')->Where('name', 'like', '%' .$busqueda. '%')->paginate(10);
        return view('users.index',['user'=>$user]);
    }
    public function update_status($id){
        try {
            $user = User::findOrFail($id);
            if($user->status == '1'){
               $user->status = '0';
            }else{
               $user->status = '1';
            }
            $user->update();
            return redirect()->back()->with('success', 'Se actualizó el estado del usuario correctamente');
        }catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|min:4|max:45',
                'surname' => 'required|min:4|max:255',
                'email'=>'required|max:120',
                'phone' => 'required|min:9|max:9',
            ]);
            $valueId=User::where('email', '=', $validated['email'])->first();
            if(isset($valueId))
            {
                return redirect()->route('user.index')->with('error','Tu email ya existe');
            }
            $time = Carbon::now('America/Lima');
            $password=generatorPassword($validated['name'],$validated['surname'],$validated['phone']);
            $fullname=generatorFullname($validated['name'],$validated['surname']);
            $user =new User;
            $user->name = $fullname;
            $user->phone = $validated['phone'];
            $user->password = bcrypt($password);
            $user->role = 'REPA';
            $user->status = '1';
            //
            //$user->is_email_verified = '1';
            //
            $user->email = $validated['email'];
            $user->perfil='image/avatars/profiles/avatar-1.jpg';
            $user->save();


            $receivers = $validated['email'];
            Mail::to($receivers)->send(new Password($password));

            $token=quickRandom(100);
            $emailVerify=Email_verify::where('email','=',$validated['email'])->first();
            if($emailVerify)
            {
                return redirect()->route('Inicio')->with('success', 'Verificacion Enviada');
            }
            else
            {
                $emailVerify=new Email_verify;
                $emailVerify->email=$receivers;
                $emailVerify->token=$token;
                $emailVerify->save();
            }
            Mail::to($receivers)->send(new Verification($token));

            return redirect()->route('user.index')->with('success', 'Registro con exito');
        }catch (\Exception $e) {
            return redirect()->route('user.index')->with('error', $e->getMessage());
        }
    }
    public function reset_password(Request $request)
    {
        try {
            $validated = $request->validate([
                'delete' => 'required',
                'id' => 'required',
            ]);

            if(!(strtoupper($validated['delete'])=="CONFIRMAR")) return redirect()->route('user.index')->with('error','Error al restablecer');
            $time = Carbon::now('America/Lima');
            $id=$validated['id'];
            $user=User::findorFail($id);
            $fullname=$user->name;
            $phone=$user->phone;
            $password=generatorPassword($fullname,'update',$phone).$time->format('Y').$time->format('m').$time->format('d');
            $user->password = bcrypt($password);
            $user->save();
            $receivers = $user->email;
            Mail::to($receivers)->send(new Password($password));
            return redirect()->route('user.index')->with('success','Contraseña restablecida');
        }catch (\Exception $e) {
            return redirect()->route('user.index')->with('error', $e->getMessage());
        }
    }
    public function destroy(Project $project)
    {
        $user = User::findOrFail($project->id);
        $user->destroy($project->id);

        return redirect()->back()->with('success','Eliminacion con exito');
    }
    public function management()
    {
        $load=load();
        $countCart=$load['countCart'];
        $perfil=$load['perfil'];
        return view('users.profiles.management',['countCart'=>$countCart,'perfil'=>$perfil]);
    }
    public function edit_profile()
    {
        //refactorizar @2
        $load=load();
        $countCart=$load['countCart'];
        $perfil=$load['perfil'];

        $user=User::find(Auth::user()->id);
        return view('users.profiles.profile',['countCart'=>$countCart,'user'=>$user,'perfil'=>$perfil]);
    }
    public function update_profile(Request $request)
    {

        try {
            $validated = $request->validate([
                'fullname'=>'required|min:10|max:255',
                'phone' => 'required|min:9|max:9',
                'image'=>['required','image']
            ]);
            $user=User::find(Auth::user()->id);
            if($user && $validated)
            {
                $user->perfil=$ruteImage=$validated['image']->store('image/avatars/profiles','public');
                $user->name=$validated['fullname'];
                $user->phone=$validated['phone'];
                $user->save();
            }
            return redirect()->back()->with('success','Se actualizo con exitosamente');
        }catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
