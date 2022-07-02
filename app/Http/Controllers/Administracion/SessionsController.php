<?php

namespace App\Http\Controllers\Administracion;

use DateTime;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Email_verify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\SessionsFormUser;
use App\Http\Controllers\Controller;

class SessionsController extends Controller
{
    public function __construct()
    {

    }
    public function store(SessionsFormUser $request)
    {
        $validate=$request->validated();

        if(Auth::attempt(['email' => $validate['email'], 'password' => $validate['password']])== false)
        {
            return redirect()->to('/')->with('error','Sus datos no coinciden con ninguna cuenta');
        }
        else
        {
            if (((Auth::user()->is_email_verified == 0)?true:false)) {
                Auth::logout();
                return redirect()->route('Inicio')->with('error', 'Confirme su email');
            }
            elseif(((Auth::user()->status == 0)?true:false))
            {
                Auth::logout();
                return redirect()->route('Inicio')->with('error', 'Estado inactivo su email');
            }
            else
            {
                if(!(Auth::user()->role=="ADMIN"))
                {
                    return redirect()->route('Inicio');
                }
                return redirect()->route('order.panel');
            }
        }
    }
    public function destroy(){
        Auth::logout();
        return redirect()->to('/');
    }
    public function verification($token)
    {

        $time = Carbon::now('America/Lima');
        $emailVerify=Email_verify::where('token','=',$token)->first();

        if($emailVerify->token == $token)
        {
            $date = new DateTime();
            $user=User::where('email','=',$emailVerify->email)->first();
            $user->email_verified_at=$time->format('Y-m-d H:i:s');
            $user->is_email_verified=1;
            $user->save();
        }
        return redirect()->route('Inicio')->with('success','Registro con exito');
    }

}
