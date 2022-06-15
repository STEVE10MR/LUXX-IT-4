<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CategoriesController extends Controller
{
    public function __construct(){
        $this->middleware('admin');
    }

    public function index(Request $request){

        $busqueda=$request->get('search')?$request->get('search'):'';
        $categories=Category::select('id','category','description')->orderBy('id',request('sorted','ASC'))->Where('category', 'like', '%' .$busqueda. '%')->paginate(10);
        return view('categories.index',['categories'=>$categories]);

    }
    public function store(Request $request){
        $validated = $request->validate([
            'category' => 'required|min:4|max:45',
            'description' => 'required|min:4|max:120',
        ]);
        $category=new Category;
        $category->category=$validated['category'];
        $category->description=$validated['description'];
        $category->save();
        Session::flash('success', 'Se registro con exitosamente');
        return redirect()->back();


    }
    public function update(Request $request,$id){
        $validated = $request->validate([
            'category' => 'required|min:4|max:45',
            'description' => 'required|min:4|max:120',
        ]);
        $category=Category::findOrFail($id);
        try
        {
            $category->category=$validated['category'];
            $category->description=$validated['description'];
            $category->save();
            Session::flash('success', 'Se actualizo exitosamente');
            return redirect()->back();
        }catch (\Exception $e) {
            Session::flash('danger', 'Hubo un problema inesperado al actualizar');
            return redirect()->back();
        }
    }
    public function destroy($id){
        $category=Category::findOrFail($id);
        try
        {
            $category->delete();
            Session::flash('success', 'Se elimino exitosamente');
            return redirect()->back();
        }catch (\Exception $e) {
            Session::flash('danger', 'Hubo un problema inesperado al eliminar');
            return redirect()->back();
        }
    }
}
