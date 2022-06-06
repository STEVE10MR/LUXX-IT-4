<?php

use App\Models\User;

function load()
{
    $countCart=0;
    $perfil=null;
    if (Auth::check()) {
        $countCart=DB::table('cart')->where('user_id', '=', Auth::user()->id)->get()->count();
        $user=User::find(Auth::user()->id);
        $perfil=$user->perfil;
    }
    return ['countCart'=>$countCart,'perfil'=>$perfil];
}
