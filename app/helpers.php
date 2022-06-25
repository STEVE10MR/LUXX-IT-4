<?php

use Carbon\Carbon;
use App\Models\User;

function load()
{
    $countCart=0;
    $perfil=null;
    if (Auth::check()) {
        $user=User::find(Auth::user()->id);
        $perfil=$user->perfil;
        if(Auth::user()->role == "USER"){
            $countCart=DB::table('cart')->where('user_id', '=', Auth::user()->id)->get()->count();
        }
        elseif(Auth::user()->role == "REPA")
        {
            $time = Carbon::now('America/Lima');
            $date=$time->format('Y-m-d');
            $countCart=DB::table('orders')->whereNull('orders.delivery_id')->where('created_at','LIKE',''.$date.'%')->get()->count();
        }
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

function stringToArray($data)
{

    return $data."";
}
function arrayToString($data)
{
    $productURL="";
    foreach($data->toArray() as $product)
    {
        $productURL.=$product->id."&".$product->producto."&".$product->price."-";
    }
    $productURL=substr($productURL,1,(strlen($productURL)-2));
    return $productURL;
}
function quickRandom($length = 16)
{
    $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    return substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
}
