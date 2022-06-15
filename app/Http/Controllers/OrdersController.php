<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrdersController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('admin')->except('my_orders');
    }
    public function index(){
        $countProduct=DB::table('products')->count();
        $sales=DB::table('orders')->max('amount');
        $countDelivery=DB::table('users')->Where('role','=','REPA')->count();
        return view('orders.panel',['countProduct'=>$countProduct,'sales'=>$sales,'countDelivery'=>$countDelivery]);
    }
    function my_orders()
    {
        $load=load();
        $countCart=$load['countCart'];
        $perfil=$load['perfil'];
        return view('users.profiles.orders',['countCart'=>$countCart,'perfil'=>$perfil]);
    }
}
