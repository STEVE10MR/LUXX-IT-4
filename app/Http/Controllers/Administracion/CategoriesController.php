<?php

namespace App\Http\Controllers\Administracion;


use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;

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

        try {
            $validated = $request->validate([
                'category' => 'required|min:4|max:45',
                'description' => 'required|min:4|max:120',
            ]);
            $category=new Category;
            $category->category=$validated['category'];
            $category->description=$validated['description'];
            $category->save();
            return redirect()->back()->with('success', 'Se agrego la categoria');
        }catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function update(Request $request,$id){
        try {
            $validated = $request->validate([
                'category' => 'required|min:4|max:45',
                'description' => 'required|min:4|max:120',
            ]);
            $category=Category::findOrFail($id);
            $category->category=$validated['category'];
            $category->description=$validated['description'];
            $category->save();
            return redirect()->back()->with('success', 'Se actualizo la categoria');
        }catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function destroy($id){
        try {
            $category=Category::findOrFail($id);
            $category->delete();
            return redirect()->back()->with('success', 'Se elimino la categoria');
        }catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
