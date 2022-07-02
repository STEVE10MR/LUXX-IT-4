<?php

namespace App\Http\Controllers\Ventas;

use Carbon\Carbon;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class OrdersController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('admin')->except(['my_orders','deliver_orders','my_deliveries']);
    }
    public function index(){

        $countProduct=DB::table('products')
        ->count();
        $orders=DB::table('orders')
        ->join('users','users.id','=','orders.delivery_id')
        ->select('orders.id','users.name','orders.amount','orders.created_at')
        ->where('recept','=','1')
        ->get();
        $countDelivery=DB::table('users')->Where('role','=','REPA')->count();

        $resumeProducts=array();
        $time = Carbon::now('America/Lima');
        $monthACT=intval($time->format('m'));
        $yearACT=intval($time->format('Y'));

        $amountACT=0;
        $amountANT=0;

        foreach($orders as $order)
        {
            $month=intval(date("m",strtotime($order->created_at)));
            $year=intval(date("Y",strtotime($order->created_at)));
            $monthANT=$monthACT-1;

            if($yearACT == $year)
            {
                if($monthANT == $month)
                {
                    $amountANT+=$order->amount;
                }
                if($monthACT == $month)
                {
                    $amountACT+=$order->amount;
                }
            }
            $orderDetails=DB::table('ordersdetails')
            ->select('name')
            ->join('products','products.id','=','ordersdetails.product_id')
            ->where('ordersdetails.order_id','=',$order->id)
            ->get();
            $resumeProducts[$order->id]=json_decode($orderDetails,true);

        }
        //return $amountACT;
        $increment=intval((($amountACT/($amountANT == 0? 1:$amountANT))-1)*100);
        return view('orders.panel',['countProduct'=>$countProduct,'sales'=>$amountACT,'countDelivery'=>$countDelivery,'orders'=>$orders,'resumeProducts'=>$resumeProducts,'increment'=>$increment]);

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
        //return $orders;
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
    function my_deliveries()
    {
        $load=load();
        $countCart=$load['countCart'];
        $perfil=$load['perfil'];

        $orders=DB::table('orders')
        ->select('orders.id','reference','amount','recept','updated_at')
        ->orderBy('created_at',request('sorted','ASC'))
        ->join('address','address.id','=','orders.address_id')
        ->where('delivery_id','=',Auth::user()->id)
        ->get();

        $resumeProducts=array();
        //return $orders;
        foreach($orders as $order)
        {
            $order->updated_at=Carbon::parse($order->updated_at);
            $orderDetails=DB::table('ordersdetails')
            ->select('name')
            ->join('products','products.id','=','ordersdetails.product_id')
            ->where('ordersdetails.order_id','=',$order->id)
            ->get();
            $resumeProducts[$order->id]=json_decode($orderDetails,true);

        }

        return view('users.profiles.deliveries',['countCart'=>$countCart,'perfil'=>$perfil,'orders'=>$orders,'resumeProducts'=>$resumeProducts]);
    }
    function deliver_orders()
    {
        $load=load();
        $countCart=$load['countCart'];
        $perfil=$load['perfil'];
        $time = Carbon::now('America/Lima');
        $date=$time->format('Y-m-d');
        $delivery_id = Auth::user()->id;

        $orderPending=DB::table('orders')
        ->select('orders.id')
        ->where('delivery_id','=',$delivery_id)
        ->where('recept','=','0')
        ->orderBy('created_at','DESC')
        ->first();

        $orderId=$orderPending?$orderPending->id:0;

        $orders=DB::table('orders')
        ->join('address','address.id','=','orders.address_id')
        ->select('orders.id','orders.address_id','reference','status','amount','pay_type','orders.created_at')
        ->whereNull('orders.delivery_id')
        ->where('created_at','LIKE',''.$date.'%')
        ->orWhere('orders.id','=',$orderId)
        ->orderBy('created_at','ASC')
        ->get();

        $resumeProducts=array();
        //return $orders;
        foreach($orders as $order)
        {
            $order->created_at=Carbon::parse($order->created_at);
            $orderDetails=DB::table('ordersdetails')
            ->select('name')
            ->join('products','products.id','=','ordersdetails.product_id')
            ->where('ordersdetails.order_id','=',$order->id)
            ->get();
            $resumeProducts[$order->id]=json_decode($orderDetails,true);

        }
        return view('orders.order',['countCart'=>$countCart,'perfil'=>$perfil,'orders'=>$orders,'resumeProducts'=>$resumeProducts,'orderPending'=>$orderId]);
    }
    function statistics()
    {
        $orders=DB::table('orders')
        ->where('recept','=','1')
        ->get();

        $time = Carbon::now('America/Lima');
        $monthACT=intval($time->format('m'));
        $yearACT=intval($time->format('Y'));

        $amount_totals=array(
            1=>0,
            2=>0,
            3=>0,
            4=>0,
            5=>0,
            6=>0,
            7=>0,
            8=>0,
            9=>0,
            10=>0,
            11=>0,
            12=>0
        );
        $months=array(1=>"Enero",2=>"Febrero",3=>"Marzo",4=>"Abril",5=>"Mayo",6=>"Junio",7=>"Julio",8=>"Agosto",9=>"Septiembre",10=>"Octubre",11=>"Noviembre",12=>"Diciembre");
        foreach($orders as $order)
        {
            $month=intval(date("m",strtotime($order->created_at)));
            $year=intval(date("Y",strtotime($order->created_at)));

            if($yearACT == $year)
            {
                $amount_totals[$month]=($amount_totals[$month]+($order->amount));
            }
        }

        $dataMount=array();
        $dataMonth=array();
        for($i=1;$i<=$monthACT;$i++)
        {
            array_push($dataMount,$amount_totals[$i]);
            array_push($dataMonth,$months[$i]);
        }

        return view('orders.statistics',['dataMount'=>$dataMount,'dataMonth'=>$dataMonth]);
    }
}
