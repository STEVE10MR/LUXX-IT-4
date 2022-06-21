<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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
        $orders=DB::table('orders')
        ->select('orders.id','reference','status','amount','pay_type','created_at','updated_at')
        ->orderBy('created_at',request('sorted','ASC'))
        ->join('address','address.id','=','orders.address_id')
        ->where('client_id','=',Auth::user()->id)
        ->get();

        $resumeProducts=array();

        foreach($orders as $order)
        {
            $orderDetails=DB::table('ordersdetails')
            ->select('name')
            ->join('products','products.id','=','ordersdetails.product_id')
            ->where('ordersdetails.order_id','=',$order->id)
            ->get();
            $resumeProducts[$order->id]=json_decode($orderDetails,true);

        }


        return view('users.profiles.orders',['countCart'=>$countCart,'perfil'=>$perfil,'orders'=>$orders,'resumeProducts'=>$resumeProducts]);
    }
}
