<?php

namespace App\Http\Controllers\Pedidos;

use Culqi\Culqi;
use Carbon\Carbon;
use App\Models\Cart;
use App\Models\User;
use App\Mail\Rechnung;
use App\Models\Orders;
use App\Models\Address;
use App\Models\Products;
use Illuminate\Http\Request;
use App\Models\OrdersDetails;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;



class ClientController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('index');
        $this->middleware('client')->only(['add_cart','add_cart_detail']);
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
        try {
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
            return redirect()->back()->with('success', "Se agrego al carrito el producto $product->name");
        }catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }



    function add_cart_detail(Request $request){
        try {
            $validated = $request->validate([
                'product_id'=>'required',
                'product_cant' => 'required|numeric|min:1|max:10',
            ]);

            //refactorizar @1
            $cart=Cart::whereRaw('product_id = ? and user_id = ?', [$validated['product_id'],Auth::user()->id])->first();

            $cartQuantity=isset($cart->quantity)?$cart->quantity:0;
            $productCant=intval($validated['product_cant']);

            $cartVerify=(($cartQuantity+$productCant)>=10)?10:($cartQuantity+$productCant);


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
            return redirect()->back()->with('success', "Se agrego al carrito el producto");
        }catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    function open_cart(){
        //refactorizar @2
        $load=load();
        $countCart=$load['countCart'];
        $perfil=$load['perfil'];
        $iduser=Auth::user()->id;
        $cart=DB::table('cart')->join('products', 'products.id', '=', 'cart.product_id')
        ->select('products.portada','cart.producto', 'cart.quantity', 'cart.price','cart.id','products.id as product_id')
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
        try {
            $cart = Cart::find($id);
            $cart->destroy($id);
            return redirect()->back()->with('success', 'Se elimino el producto del carrito exitosamente');
        }catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
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
        $producDeleteImage=array();
        foreach(array_values(json_decode($validated['products'],true)) as $product)
        {
            $productModel =new Products;
            $productModel->producto= $product['producto'];
            $productModel->quantity=$product['quantity'];
            $productModel->price=$product['price'];
            $productModel->id=$product['product_id'];
            array_push($producDeleteImage,$productModel);
        }

        $address=Address::select('reference','id')->where('user_id','=',''.$validated['user_id'].'')->get();
        return view('product.checkout',['countCart'=>$countCart,'perfil'=>$perfil,'products'=>$producDeleteImage,'user_id'=>$validated['user_id'],'total'=>$validated['total'],'address'=>$address]);
    }
    function generar_pedido($products,$user_id,$total,$token,$address_id,$method){

        try {
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
                    return redirect()->route('Inicio')->with('error', 'Se rechazó la tarjera de crédito, intente con otra.');
                }
            }

            $order = new Orders;
            $order->client_id=$user_id;
            $order->address_id=$address_id;
            $order->status='En espera';
            $order->recept='0';
            $order->amount=$total;
            $order->pay_type=$method;
            $order->save();

            $order_id=$order->id;
            $cont=0;
            $cart = Cart::where('user_id','=',$user_id)->get();
            foreach(json_decode($products,true) as $product)
            {
                $orderdetail= new OrdersDetails;
                $orderdetail->order_id= $order_id;
                $orderdetail->product_id=$product['id'];
                $orderdetail->quantity=intval($product['quantity']);
                $orderdetail->price=floatval($product['price']);
                $orderdetail->save();

                $carDel=Cart::findOrFail($cart[$cont]->id);
                $carDel->delete();
                $cont = $cont+1;
            }
            $time = Carbon::now('America/Lima');

            $userReceiver=User::findOrFail($user_id);
            $name=$userReceiver->name;
            $date=$time->format('Y-m-d');
            $receivers=$userReceiver->email;





            Mail::to($receivers)->send(new Rechnung($name,$receivers,json_decode($products,true),$total,$date,$order_id));
            return redirect()->route('Inicio')->with('success', 'Se registro correctamente su orden');
        }catch (\Exception $e) {
            return redirect()->route('Inicio')->with('error', $e->getMessage());
        }
    }
}
