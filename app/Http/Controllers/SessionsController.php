<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\SessionsFormUser;

class SessionsController extends Controller
{

    public function store(SessionsFormUser $request)
    {
        $validate=$request->validated();
        if(Auth::attempt(['email' => $validate['email'], 'password' => $validate['password']])== false)
        {
            return redirect()->to('/');
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
    public function destroy(){
        Auth::logout();
        return redirect()->to('/');
    }
}
