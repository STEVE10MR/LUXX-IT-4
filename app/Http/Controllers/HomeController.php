<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $galeria = DB::table('galeria')->take('4')->get();
        $producto = DB::table('products')->paginate(15);
        return view('home',['galeria'=>$galeria,'producto'=>$producto]);
    }
}
