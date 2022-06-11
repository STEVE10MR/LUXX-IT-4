<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Products;
use Illuminate\Http\Request;
use App\Http\Requests\SaveFormUser;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(){
        $this->middleware('admin');
    }

    public function index_panel(){
        return view('admin.panel');
    }
    public function index(Request $request){
        $busqueda=$request->get('search')?$request->get('search'):'';
        $user=User::select('id','name', 'email','phone','status','created_at','updated_at')->orderBy('created_at',request('sorted','ASC'))->Where('role','=','REPA')->Where('role','=','REPA')->Where('name', 'like', '%' .$busqueda. '%')->paginate(10);
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

            Session::flash('success', 'Se actualizó el estado del usuario correctamente');
            return redirect()->back();
       } catch (\Exception $e) {
            Session::flash('danger', $e);
            return redirect()->back();
       }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:45',
            'surname' => 'required|max:255',
            'email'=>'required|max:120',
            'phone' => 'required|min:9|max:9',
        ]);

        $valueId=User::where('email', '=', $validated['email'])->first();
        if(isset($valueId))
        {
            return redirect()->route('user.index')->with('validatex','Tu email ya existe');
        }

        $password=generatorPassword($validated['name'],$validated['surname'],$validated['phone']);
        $fullname=generatorFullname($validated['name'],$validated['surname']);

        $user =new User;
        $user->name = $fullname;
        $user->phone = $validated['phone'];
        $user->password = bcrypt($password);
        $user->role = 'REPA';
        $user->email = $validated['email'];
        $user->perfil='image/avatars/profiles/avatar-1.jpg';

        $user->save();
        return redirect()->route('user.index')->with('success','Registro con exito');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('users.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(User $user,SaveFormUser $request)
    {


        $validate=$request->validated();

        $user->name = $validate['name'];
        $user->password = bcrypt($validate['password']);
        $user->email = $validate['email'];

        $user->save();

        return redirect()->route('inicio')->with('success','Registro con exito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $user = User::findOrFail($project->id);
        $user->destroy($project->id);

        return redirect()->back()->with('success','Eliminacion con exito');
    }
}
