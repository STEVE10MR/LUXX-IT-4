<?php

namespace App\Http\Controllers\Administracion;

use App\Models\Category;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;





class ProductsController extends Controller
{
    public function __construct(){
        $this->middleware('admin')->except('create_menu','show');
    }

    public function index(Request $request){
        $busqueda=$request->get('search')?$request->get('search'):'';
        $category=Category::select('id','category')->get();
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

        try
        {
            $validated = $request->validate([
                'name' => 'required|max:45',
                'description' => 'required|max:255',
                'prices'=>'required',
                'image'=>'required|max:2048',
                'category_id'=>'required',
            ]);
            $ruteImage=$validated['image']->store('image/product','public');
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

            return redirect()->back()->with('success', 'Se agrego el producto');

        }
        catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function create_menu(Request $request)
    {

        $load=load();
        $countCart=$load['countCart'];
        $perfil=$load['perfil'];
        $busqueda=$request->get('search')?$request->get('search'):'';
        $order=$request->get('order')?$request->get('order'):'';
        $cat=$request->get('category')?$request->get('category'):'';


        $category=Category::select('id','category')->get();

        $searchOrder="";
        $type="";

        if($order >=1 && $order<=2)
        {
            $searchOrder="name";
            if($order == 1) $type="asc";
            else $type="desc";
        }
        elseif($order >=3 && $order<=4)
        {
            $searchOrder="price";
            if($order == 3) $type="asc";
            else $type="desc";
        }
        else
        {
            $searchOrder="name";
            $type="asc";
        }
        //
        $products=Products::join('category', 'category.id', '=', 'products.category_id')->orderBy($searchOrder,$type)->Where('name', 'like', '%' .$busqueda. '%')->Where('status','=','1')->whereBetween('category_id',[$cat?$cat:1,$cat?$cat:1000])->paginate(10);
        $results=count($products);
        $resultsSearch=$busqueda;


        /*
        $key = "products.page.".request('page',1);

        $ttl=60;
        $products=Cache::remember($key, $ttl, function () {
            return Products::orderBy('created_at',request('sorted','ASC'))->paginate(8);
        });
        */


        return view('product.menu',compact('products','countCart','perfil','category','results','resultsSearch','order','cat'));

    }


    public function update(Request $request,$id){

        try
        {
            $validated = $request->validate([
                'name' => 'required|max:45',
                'description' => 'required|max:255',
                'prices'=>'required',
                'category_id'=>'required',
                'image'=>'required|max:2048',
            ]);

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

            return redirect()->back()->with('success', 'Se agrego el producto');

        }
        catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function update_status($id){
        try
        {
            $product = Products::findOrFail($id);
             if($product->status == '1'){
                $product->status = '0';
             }else{
                $product->status = '1';
             }
             $product->update();

            return redirect()->back()->with('success', 'Se actualizó el estado del producto correctamente');

        }
        catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


}
