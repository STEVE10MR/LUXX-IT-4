<?php

namespace App\Http\Controllers\Administracion;

use App\Models\User;
use App\Mail\Verification;
use App\Models\Email_verify;
use Illuminate\Http\Request;
use App\Http\Requests\SaveFormUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;


class RegisterController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
    public function create()
    {
        $countCart=0;
        if (Auth::check()) {
            $countCart=DB::table('cart')->where('user_id', '=', Auth::user()->id)->get()->count();
        }
        return view('users.register',['countCart'=>$countCart]);
    }
    public function store(SaveFormUser $request)
    {
        try
        {
            $validate= $request->validated();
            if(!($validate['password'] == $validate['password_r']))
            {
                return redirect()->route('register.create')->with('error', 'No coincide tu contraseña');
            }
            $valueId=User::where('email', '=', $validate['email'])->first();
            if(isset($valueId))
            {
                return redirect()->route('register.create')->with('error', 'Tu email ingresado ya existe');
            }
            $user =new User;
            $user->name = $validate['nombres']." ".$validate['apellidos'];
            $user->password =  bcrypt($validate['password']);
            $user->phone=$validate['numero'];
            $user->role = 'USER';
            $user->email = $validate['email'];
            $user->perfil='image/avatars/profiles/avatar-1.jpg';
            $user->save();
            $token=quickRandom(100);
            $receivers = $validate['email'];
            $emailVerify=Email_verify::where('email','=',$validate['email'])->first();
            if($emailVerify)
            {
                return redirect()->route('Inicio')->with('success', 'Verifica tu cuenta de NutriFit');
            }
            else
            {
                $emailVerify=new Email_verify;
                $emailVerify->email=$receivers;
                $emailVerify->token=$token;
                $emailVerify->save();
            }
            Mail::to($receivers)->send(new Verification($token));
            return redirect()->route('Inicio')->with('success', 'Verifica tu cuenta de NutriFit');
        }
        catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
