<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;





class ProductsController extends Controller
{
    public function __construct(){
        $this->middleware('admin')->except('create_menu','show');
    }

    public function index(Request $request){
        $category=Category::select('id','category')->get();
        $product=Products::join('category', 'category.id', '=', 'products.category_id')->select('category.id as cat_id','category.category','products.id','products.name','products.price','products.status','products.descripcion','products.portada')->orderBy('created_at',request('sorted','ASC'))->paginate(10);
        return view('product.index',['product'=>$product,'category'=>$category]);

    }
    public function search(Request $request)
    {
        $validated = $request->validate([
            'search'=>'required',
        ]);
        $busqueda=$validated['search'];
        $product=null;
        $category=Category::get();
        $product=Products::join('category', 'category.id', '=', 'products.category_id')->select('category.id as cat_id','category.category','products.id','products.name','products.price','products.status','products.descripcion','products.portada')->orderBy('created_at',request('sorted','ASC'))->Where('name', 'like', '%' .$busqueda. '%')->paginate(10);
        return view('product.index',['product'=>$product,'category'=>$category]);
    }

    public function show(Products $product){
        $load=load();
        $countCart=$load['countCart'];
        $perfil=$load['perfil'];
        return view('product.details',['product'=>$product,'countCart'=>$countCart,'perfil'=>$perfil]);

        /*
        return Cache::rememberForever('product' . $product->id, function() use ($product) {
            $countCart=0;
            if (Auth::check()) {
                $countCart=DB::table('cart')->where('user_id', '=', Auth::user()->id)->get()->count();
            }

            return view('product.details',['product'=>$product,'countCart'=>$countCart])->render();
        });
        */
    }
    function create(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required|max:45',
            'description' => 'required|max:255',
            'prices'=>'required',
            'image'=>'required|max:2048',
            'category_id'=>'required',
        ]);


        if(!$validated)
        {
            Session::flash('success', 'Error al registrar');
            return redirect()->back();
        }
        $ruteImage=$validated['image']->store('image/product/','public');
        $product = new Products;
        $product->category_id=$validated['category_id'];
        $arrName=explode(" ",$validated['name']);
        $urlName='';
        foreach($arrName as $value)
        {
            $urlName.=strtolower($value).'-';
        }
        $product->url='product'.'-'.$urlName.'tacna';
        $product->portada=$ruteImage;
        $product->name=$validated['name'];
        $product->descripcion=$validated['description'];
        $product->price=round(floatval($validated['prices']),2);
        $product->status=1;

        $product->save();

        Session::flash('success', 'Se registro con exitosamente');
        return redirect()->back();
    }

    public function create_menu()
    {
        //$countProducts = DB::table('products')->count();

        //$paginateProducts=ceil($countProducts/12)>0?ceil($countProducts/12):1;
        //modify -> delivery.test
        $load=load();
        $countCart=$load['countCart'];
        $perfil=$load['perfil'];

        $key = "products.page.".request('page',1);

        $ttl=60;
        $products=Cache::remember($key, $ttl, function () {
            return Products::orderBy('created_at',request('sorted','ASC'))->paginate(8);
        });

        return view('product.menu',compact('products','countCart','perfil'));

    }

    public function edit($id){

        return "GAA";
        $productDetail = Alimento::findOrFail($id);
        $categorias = DB::table('category')
        ->get();
        return view('productos.edit',['productDetail'=>$productDetail]);
    }

    public function update(Request $request,$id){
        $validated = $request->validate([
            'name' => 'required|max:45',
            'description' => 'required|max:255',
            'prices'=>'required',
            'category_id'=>'required',
            'image'=>'required|max:2048',
        ]);

        try
        {
            if(!$validated)
            {
                Session::flash('success', 'Error al actualizar');
                return redirect()->back();
            }
            $ruteImage=$validated['image']->store('image/product/','public');
            $product = Products::findorFail($id);
            $product->category_id=$validated['category_id'];
            $arrName=explode(" ",$validated['name']);
            $urlName='';
            foreach($arrName as $value)
            {
                $urlName.=strtolower($value).'-';
            }
            $product->url='product'.'-'.$urlName.'tacna';
            $product->portada=$ruteImage;
            $product->name=$validated['name'];
            $product->descripcion=$validated['description'];
            $product->price=round(floatval($validated['prices']),2);
            $product->status=1;

            $product->save();

            Session::flash('success', 'Se actualizo exitosamente');
            return redirect()->back();
        }catch (\Exception $e) {
            Session::flash('danger', $e);
            return redirect()->back();
        }
    }

    public function update_status($id){
        try {
             $product = Products::findOrFail($id);
             if($product->status == '1'){
                $product->status = '0';
             }else{
                $product->status = '1';
             }
             $product->update();

             Session::flash('success', 'Se actualizó el estado del producto correctamente');
             return redirect()->back();
        } catch (\Exception $e) {
             Session::flash('danger', $e);
             return redirect()->back();
        }
    }


}
