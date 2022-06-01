<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Cart;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class ClientController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('index');
    }
    public function index()
    {
        $galeria = DB::table('galeria')->take('4')->get();

        $countCart=0;
        if (Auth::check()) {
            $countCart=DB::table('cart')->where('user_id', '=', Auth::user()->id)->get()->count();
        }

        $producto = DB::table('products')
        ->orderby('id','desc')
        ->limit(10)
        ->get();


        return view('home',['galeria'=>$galeria,'producto'=>$producto,'countCart'=>$countCart]);
    }
    function add_cart(Products $product){

        //Steve
        //falta validaciones

        $time = Carbon::now('America/Lima');

        $cart = new Cart;
        $cart->product_id=$product->id;
        $cart->user_id=Auth::user()->id;
        $cart->producto=$product->name;
        $cart->quantity=1;
        $cart->price=$product->price;
        $cart->create=$time->format('Y-m-d');
        $cart->save();
        Session::flash('success', 'Se agregó al carrito exitosamente');
        return redirect()->back();

    }

    function open_cart(){
        return view('product.cart');

    }

    public function destroy_carrito($id){
        $carrito = Carrito::findOrFail($id);
        $carrito->destroy($id);

        return redirect()->back();
    }
}
