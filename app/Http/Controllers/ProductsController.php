<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function __construct(){
        $this->middleware('admin');
    }

    public function index(Request $request){
        $search = $request->get('search');
        $productos = DB::table('products')
        ->where([
            ['titulo','LIKE','%'.$search.'%']
        ])
        ->orderby('id','desc')
        ->paginate(10);


        return view('----',compact('productos','search'));
    }

    public function create(){
        $categorias = DB::table('category')
        ->get();
        return view('----');
    }

    public function store(Request $request){
        $validator = $request->validate([
            'titulo'=>'required|max:250',
            'descripcion'=>'required|max:300',
            'precio'=>'required|max:250',
            'portada'=>'required|max:5000',
        ]);
        $producto = new Products;
        $producto->name = $request->get('titulo');
        $producto->descripcion = $request->get('descripcion');
        $producto->price = $request->get('precio');
        $producto->categoria = $request->get('categoria');
        $producto->status = 'Disponible';
        if($request->portada){

            $extension2 = $request->portada[0]->extension();
            try{
                    unlink(public_path('admin/'.$producto->portada));
            }
            catch(\Exception $e){
            }
            if($extension2 == 'png' || $extension2 == 'jpeg' || $extension2 == 'jpg' || $extension2 == 'webp'){
                    $imgname2 = uniqid();
                    $imageName2 = $imgname2.'.'.$request->portada[0]->extension();
                    $request->portada[0]->move(public_path('admin'), $imageName2);
                    $producto->portada = $imageName2;
            }else{
                Session::flash('danger', 'El formato de la imagen no se acepta');
                return redirect()->back();
            }
        }
        $producto->save();
        Session::flash('success', 'Se registró con exito el nuevo producto');
        return redirect()->route('admin.producto');

    }

    public function edit($id){

        $producto = Alimento::findOrFail($id);
        $categorias = DB::table('category')
        ->get();

        return view('productos.edit',compact('categorias','producto'));
    }

    public function update(Request $request,$id){

        $validator = $request->validate([
            'titulo'=>'required|max:250',
            'descripcion'=>'required|max:300',
            'precio'=>'required|max:250',
            'portada'=>'required|max:5000',
        ]);


        try
        {
            $producto = Products::findOrFail($id);;
            $producto->name = $request->get('titulo');
            $producto->descripcion = $request->get('descripcion');
            $producto->price = $request->get('precio');
            $producto->categoria = $request->get('categoria');
            $producto->status = 'Disponible';
            if($request->portada){

                $extension2 = $request->portada[0]->extension();
                try{
                        unlink(public_path('admin/'.$producto->portada));
                }
                catch(\Exception $e){
                }
                if($extension2 == 'png' || $extension2 == 'jpeg' || $extension2 == 'jpg' || $extension2 == 'webp'){
                        $imgname2 = uniqid();
                        $imageName2 = $imgname2.'.'.$request->portada[0]->extension();
                        $request->portada[0]->move(public_path('admin'), $imageName2);
                        $producto->portada = $imageName2;
                }else{
                    Session::flash('danger', 'El formato de la imagen no se acepta');
                    return redirect()->back();
                }
            }
            $producto->update();
            Session::flash('success', 'Se actualizó con exito el nuevo producto');
            return redirect()->route('----');
        }catch (\Exception $e) {
            Session::flash('danger', $e);
            return redirect()->back();
        }
    }

    public function destroy($id){
        try {
             $producto = Products::findOrFail($id);
                try{
                    unlink(public_path('admin/'.$producto->portada));
                }
                catch(\Exception $e){
                }
             $producto->destroy($id);

             Session::flash('success', 'Se eliminó el producto correctamente');
             return redirect()->back();
        } catch (\Exception $e) {
             Session::flash('danger', $e);
             return redirect()->back();
        }
     }

     public function estado($id){
        try {
             $producto = Products::findOrFail($id);
             if($producto->estado == 'Disponible'){
                $producto->estado = 'Agotado';
             }else{
                $producto->estado = 'Disponible';
             }
             $producto->update();

             Session::flash('success', 'Se actualizó el estado del producto correctamente');
             return redirect()->back();
        } catch (\Exception $e) {
             Session::flash('danger', $e);
             return redirect()->back();
        }
     }

     public function update_portada(Request $request, $id){
        $validator = $request->validate([
            'portada_oferta'=>'max:5000',
        ]);
        try {

            $producto = Products::findOrFail($id);
            if($request->portada_oferta){

                $extension2 = $request->portada_oferta[0]->extension();
                try{
                    unlink(public_path('admin/'.$$producto->portada_oferta));
                }
                catch(\Exception $e){
                }
                if($extension2 == 'png' || $extension2 == 'jpeg' || $extension2 == 'jpg' || $extension2 == 'webp'){
                    $imgname2 = uniqid();
                    $imageName2 = $imgname2.'.'.$request->portada_oferta[0]->extension();
                    $request->portada_oferta[0]->move(public_path('admin'), $imageName2);
                    $producto->portada_oferta = $imageName2;
                }else{
                    Session::flash('danger', 'El formato de la imagen no se acepta');
                    return redirect()->back();
                }
            }
            $producto->update();
            Session::flash('success', 'Se actualizó con exito el nuevo producto');
            return redirect()->route('index_oferta.producto');
        } catch (\Exception $e) {
            Session::flash('danger', $e);
            return redirect()->back();
        }
    }
}
