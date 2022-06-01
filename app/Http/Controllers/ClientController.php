<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('index');
    }
    public function index()
    {
        $galeria = DB::table('galeria')->take('4')->get();

        $producto = DB::table('products')
        ->orderby('id','desc')
        ->limit(10)
        ->get();

        return view('home',['galeria'=>$galeria,'producto'=>$producto]);
    }
    function add_cart(Products $product){

        return Auth::user()->id;
        return $product;
        return view('product.cart');
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
