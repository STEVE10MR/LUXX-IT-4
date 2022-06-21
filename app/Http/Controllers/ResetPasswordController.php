<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Mail\Password_resets;
use App\Models\Passwordresets;
use Illuminate\Support\Facades\Mail;

class ResetPasswordController extends Controller
{
    function create()
    {
        return view('users.password.password');
    }
    function store(Request $request)
    {
        $validated = $request->validate([
            'email'=>'required',
        ]);
        $token=quickRandom(100);
        $receivers = $validated['email'];

        $emailUser=User::where('email','=',$receivers)->first();

        if(!$emailUser)
        {
            return redirect()->route('session.recovery')->with('error','El gmail ingresado no existe');
        }

        $emailVerify=new Passwordresets;
        $emailVerify->email=$receivers;
        $emailVerify->token=$token;
        $emailVerify->save();

        Mail::to($receivers)->send(new Password_resets($token));
        return redirect()->route('home')->with('success','Registro con exito');
    }
    function edit($token)
    {
        return view('users.password.resetsPassword',['token_password'=>$token]);
    }
    function update(Request $request)
    {
        $validated = $request->validate([
            'password'=>'required',
            'password_r'=>'required',
            'token_pass'=>'required',
        ]);

        $token=$validated['token_pass'];
        if(!($validated['password'] == $validated['password_r']))
        {
            return redirect()->back()->with('error','Tu contraseña no es coincide');
        }

        $passwordVerify=Passwordresets::where('token','=',$token)->first();

        if(!$passwordVerify) return redirect()->back()->with('error','No existe la cuenta');

        $email=$passwordVerify->email;
        $password=$validated['password'];

        $user=User::where('email','=',$email)->first();
        $user->password=bcrypt($password);
        $user->save();
        return redirect()->route('Inicio')->with('success','Se cambio la contraseña correctamente');
    }
}
