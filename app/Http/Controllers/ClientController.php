<?php

namespace App\Http\Controllers;

use Culqi\Culqi;
use Carbon\Carbon;
use App\Models\Cart;
use App\Models\User;
use App\Models\Orders;
use App\Models\Address;
use App\Models\Products;
use Illuminate\Http\Request;
use App\Models\OrdersDetails;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;



class ClientController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('index');
    }
    public function load()
    {
        return ['count'=>$countCart,'perfil'=>$perfil];
    }
    public function index()
    {
        $galeria = DB::table('galeria')->take('4')->get();
        //refactorizar @2
        $load=load();
        $countCart=$load['countCart'];
        $perfil=$load['perfil'];

        return view('home',['galeria'=>$galeria,'countCart'=>$countCart,'perfil'=>$perfil]);
    }
    function add_cart(Products $product){
        //refactorizar @1
        $cart=Cart::whereRaw('product_id = ? and user_id = ?', [$product->id,Auth::user()->id])->first();

        $cartQuantity=isset($cart->quantity)?$cart->quantity:0;
        $productCant=1;
        $cartVerify=(($cartQuantity+$productCant)>10)?10:($cartQuantity+$productCant);


        $time = Carbon::now('America/Lima');

        if($cart)
        {
            $priceUnit=round(($cart->price/$cart->quantity),2);
            if(10 == $cartVerify)
            {
                $cartDiference=10-$cart->quantity;
                $cart->price+=$priceUnit*$cartDiference;
            }
            elseif($cartVerify<=10)
            {
                $cart->price+=$priceUnit*$productCant;
            }
        }
        else
        {
            $cart = new Cart;
            $cart->product_id=$product->id;
            $cart->user_id=Auth::user()->id;
            $cart->producto=$product->name;
            $cart->price+=($product->price)*($productCant);
        }
        $cart->quantity=$cartVerify;
        $cart->create=$time->format('Y-m-d');
        $cart->save();
        Session::flash('success', 'Se agregó al carrito exitosamente');
        return redirect()->back();
    }



    function add_cart_detail(Request $request){

        //return $request;
        $validated = $request->validate([
            'product_id'=>'required',
            'product_cant' => 'required|numeric|min:1|max:10',
        ]);

        //refactorizar @1
        $cart=Cart::whereRaw('product_id = ? and user_id = ?', [$validated['product_id'],Auth::user()->id])->first();

        $cartQuantity=isset($cart->quantity)?$cart->quantity:0;
        $productCant=intval($validated['product_cant']);

        $cartVerify=(($cartQuantity+$productCant)>10)?10:($cartQuantity+$productCant);


        $time = Carbon::now('America/Lima');

        if($cart)
        {
            $priceUnit=round(($cart->price/$cart->quantity),2);
            if(10 == $cartVerify)
            {
                $cartDiference=10-$cart->quantity;
                $cart->price+=$priceUnit*$cartDiference;
            }
            elseif($cartVerify<=10)
            {
                $cart->price+=$priceUnit*$productCant;
            }
        }
        else
        {
            $product=Products::findOrFail($validated['product_id']);
            $cart = new Cart;
            $cart->product_id=$product->id;
            $cart->user_id=Auth::user()->id;
            $cart->producto=$product->name;
            $cart->price+=($product->price)*($productCant);
        }
        $cart->quantity=$cartVerify;
        $cart->create=$time->format('Y-m-d');
        $cart->save();
        Session::flash('success', 'Se agregó al carrito exitosamente');
        return redirect()->back();
    }
    function open_cart(){
        //refactorizar @2
        $load=load();
        $countCart=$load['countCart'];
        $perfil=$load['perfil'];
        $iduser=Auth::user()->id;
        $cart=DB::table('cart')->join('products', 'products.id', '=', 'cart.product_id')
        ->select('products.portada','cart.producto', 'cart.quantity', 'cart.price','cart.id')
        ->whereRaw('user_id = ?',[Auth::user()->id])
        ->get();

        $subtotal=0;
        foreach($cart as $value)
        {
            $subtotal+=$value->price;
        }
        $impuesto=$subtotal*0.18;
        $total=$subtotal+$impuesto;
        return view('product.cart',['countCart'=>$countCart,'cart'=>$cart,'subtotal'=>$subtotal,'total'=>$total,'perfil'=>$perfil,'user_id'=>$iduser,'impuesto'=>$impuesto]);
    }

    function cart_destroy($id){
        $cart = Cart::find($id);
        if($cart)
        {
            $cart->destroy($id);
            Session::flash('success', 'Se elimino el producto del carrito exitosamente');
        }
        else
        {
            Session::flash('success', 'Error al eliminar');
        }
        return redirect()->back();
    }

    function create_pedido(Request $request){
        $load=load();
        $countCart=$load['countCart'];
        $perfil=$load['perfil'];
        $validated = $request->validate([
            'products'=>'required',
            'user_id' => 'required',
            'total' => 'required',
        ]);
        $productsJson=array_values(json_decode($validated['products'], true));
        $address=Address::select('reference','id')->where('user_id','=',''.$validated['user_id'].'')->get();
        return view('product.checkout',['countCart'=>$countCart,'perfil'=>$perfil,'products'=>$productsJson,'user_id'=>$validated['user_id'],'total'=>$validated['total'],'address'=>$address?$address:null]);
    }
    function generar_pedido($products,$user_id,$total,$token,$address_id,$method){


            if($method == 'culqi'){
                try {
                    //PRODUCCION
                    $SECRET_KEY = "sk_test_zBWxHYk3Jv7k4cRm";
                    /*
                    $culqi = new Culqi\Culqi(array('api_key' => $SECRET_KEY));

                    $charge = $culqi->Charges->create(
                        array(
                        "amount" => round($total).'00',
                        "capture" => true,
                        "currency_code" => 'PEN',
                        "description" => 'NUTRIFIT',
                        "email" => "test@culqi.com",
                        "source_id" => $token
                        )
                    );
                    */
                }catch(\Exception $e){
                    Session::flash('danger', 'Se rechazó la tarjera de crédito, intente con otra.');
                    return redirect()->route('Inicio');
                }
            }

            $order = new Orders;
            $order->client_id=$user_id;
            $order->address_id=$address_id;
            $order->status='En espera';
            $order->recept='----';
            $order->amount=$total;
            $order->pay_type=$method;
            $order->save();

            $cont=0;
            $cart = Cart::where('user_id','=',$user_id)->get();
            foreach(json_decode($products,true) as $product)
            {

                $orderdetail= new OrdersDetails;
                $orderdetail->order_id= 1;
                $orderdetail->product_id=$product['id'];
                $orderdetail->quantity=intval($product['quantity']);
                $orderdetail->price=floatval($product['price']);
                $orderdetail->save();

                $carDel=Cart::findOrFail($cart[$cont]->id);
                $carDel->delete();
                $cont = $cont+1;
            }
            Session::flash('succes', 'Se registro correctamente su orden');
            return redirect()->route('Inicio');
    }
}
