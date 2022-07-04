<?php

namespace App\Http\Controllers\Pedidos;

use Carbon\Carbon;
use Kreait\Firebase;
use App\Models\Orders;
use Illuminate\Http\Request;
use Kreait\Firebase\Factory;
use Illuminate\Support\Facades\DB;
use Kreait\Firebase\ServiceAccount;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FirebaseController extends Controller
{
    private $firebase;
    private $db;

    function __construct()
    {
        $this->middleware('auth');

        //initDatabase

        $serviceAccount = ServiceAccount::fromJsonFile('../key/realtime-9e386-firebase-adminsdk-bz0ag-5f86b33375.json');
        $this->firebase = (new Factory)
        ->withServiceAccount($serviceAccount)
        ->withDatabaseUri('https://realtime-9e386-default-rtdb.firebaseio.com/')
        ->create();

        $this->database = $this->firebase->getDatabase();


    }
    function load(Request $request)
    {
        $time = Carbon::now('America/Lima');
        $latitude=$request->lat;
        $longitude=$request->lon;
        $id=Auth::user()->id;
        $ref= $this
        ->database
        ->getReference("delivery/data/user_$id");


        $post=[
                'id'=>$id,
                'coords'=>[
                    'latitude'=>$latitude,
                    'longitude'=>$longitude
                ],
                'timestamp'=>$time,
        ];
        $user=$ref->set($post);


        /*
        foreach($ref->getValue() as $value)
        {
            $user=$value['id'];
            if($id == $user){
                $user=$ref->push($user);
            }

        }
        */

    }
    function create_map()
    {
        return view('map.mapa');

    }
    function load_map()
    {
        $time = Carbon::now('America/Lima');

        $ref= $this
        ->database
        ->getReference("delivery/data");
        $users=($ref->getValue());
        return $users;
    }
    function create(Request $request)
    {

        try
        {
            $validated = $request->validate([
                'address_id'=>'required',
                'order_id'=>'required',

            ]);
            $address_id=$validated['address_id'];
            $order_id=$validated['order_id'];

            $origin=DB::table('address')->where('id','=',$address_id)->first();

            $order=Orders::findOrFail($order_id);
            $order->delivery_id=Auth::user()->id;
            $order->status="Enviado";
            $order->save();

            $load=load();
            $countCart=$load['countCart'];
            $perfil=$load['perfil'];

            return view('orders.map' ,['countCart'=>$countCart,'perfil'=>$perfil,'lat'=>$origin->latitude,'lon'=>$origin->longitude,'order_id'=>$order_id]);

        }
        catch (\Exception $e) {
            return redirect()->route('Inicio')->with('error', $e->getMessage());
        }


        /*
        $reference = $this->database->getReference('delivery/coord');
        $reference->push(['delivery_id'=>1,'lat'=>2,'lon'=>1]);

        print_r($reference->getvalue());
        */
    }
    function update(Request $request)
    {
        try
        {
            $validated = $request->validate([
                'distance'=>'required',
                'order_id'=>'required',

            ]);

            $distance=intval($validated['distance']);
            $order_id=intval($validated['order_id']);

            if($distance > 50) return redirect()->route('delivery.orders')->with('error', 'No se encuentra dentro de la ubicacion');

            $order=Orders::findOrFail($order_id);
            $order->delivery_id=Auth::user()->id;
            $order->status="Entregado";
            $order->recept="1";
            $order->save();

            return redirect()->route('delivery.orders')->with('success', 'Se registro correctamente la entrega');

        }
        catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }


        /*
        $reference = $this->database->getReference('delivery/coord');
        $reference->push(['delivery_id'=>1,'lat'=>2,'lon'=>1]);

        print_r($reference->getvalue());
        */
    }
    function show_delivery(Request $request)
    {
        try
        {
            $id=$request->id;
            $user=DB::table('users')->select('name','phone')->find($id);
            return [$user->name,$user->phone];
        }
        catch (\Exception $e) {
            return "error";
        }
    }
}

