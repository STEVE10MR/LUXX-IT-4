<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\SaveFormUser;
use Illuminate\Support\Facades\Auth;


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


        $validate= $request->validated();



        if(!($validate['password'] == $validate['password_r']))
        {
            return redirect()->route('register.create')->with('validatex','Tu contraseña no es correcta');
        }

        $valueId=User::where('email', '=', $validate['email'])->first();

        if(isset($valueId))
        {
            return redirect()->route('register.create')->with('validatex','Tu email ya existe');
        }


        $user =new User;
        $user->name = $validate['nombres']." ".$validate['apellidos'];
        $user->password =  bcrypt($validate['password']);
        $user->phone=$validate['numero'];
        $user->role = 'USER';
        $user->email = $validate['email'];
        $user->perfil='image/avatars/profiles/avatar-1.jpg';
        $user->save();


        return redirect()->route('home')->with('success','Registro con exito');


    }
}
