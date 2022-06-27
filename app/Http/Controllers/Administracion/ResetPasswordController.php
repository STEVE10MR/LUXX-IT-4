<?php

namespace App\Http\Controllers\Administracion;

use App\Models\User;
use Illuminate\Http\Request;
use App\Mail\Password_resets;
use App\Models\Passwordresets;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;

class ResetPasswordController extends Controller
{
    function create()
    {
        return view('users.password.password');
    }
    function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'email'=>'required',
            ]);
            $token=quickRandom(100);
            $receivers = $validated['email'];
            $emailUser=User::where('email','=',$receivers)->where('is_email_verified','=','1')->first();


            $emailVerify=new Passwordresets;
            $emailVerify->email=$receivers;
            $emailVerify->token=$token;
            $emailVerify->save();

            Mail::to($emailUser->email)->send(new Password_resets($token));

            return redirect()->route('Inicio')->with('success','Revise su correo electronico para continuar con el proceso de cambio');
        }catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    function edit($token)
    {
        return view('users.password.resetsPassword',['token_password'=>$token]);
    }
    function update(Request $request)
    {
        try {
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

            if(!$passwordVerify) return redirect()->back()->with('error','No existe la token');

            $email=$passwordVerify->email;
            $password=$validated['password'];

            $user=User::where('email','=',$email)->first();
            $user->password=bcrypt($password);
            $user->save();
            return redirect()->route('Inicio')->with('success','Se cambio la contraseña correctamente');
        }catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
