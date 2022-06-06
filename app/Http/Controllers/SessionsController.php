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
            return redirect()->back();
        }
        return redirect()->route('Inicio');
    }
    public function destroy(){
        Auth::logout();
        return redirect()->to('/');
    }
}
