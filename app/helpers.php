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
function generatorPassword($name,$surname,$phone)
{

    $valueA=implode('',explode(' ',$name));
    $valueB=implode('',explode(' ',$surname));

    $dateA=substr(strtolower($valueA),0,3);
    $dateB=substr(strtolower($valueB),0,4);
    $dateC=substr(strtolower($phone),3,5);


    return $dateA.$dateB.$dateC;
}
function generatorFullname($name,$surname)
{

    $valueA=explode(' ',strtolower($name));
    $valueB=explode(' ',strtolower($surname));

    $nameCorrect='';
    $surnameCorrect='';
    foreach($valueA as $value)
    {
        $nameCorrect.=ucfirst($value)." ";
    }
    foreach($valueB as $value)
    {
        $surnameCorrect.=ucfirst($value)." ";
    }

    return $nameCorrect." ".$surnameCorrect;

}
