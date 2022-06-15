<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AddressController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $load=load();
        $countCart=$load['countCart'];
        $perfil=$load['perfil'];
        return view('users.profiles.address',['countCart'=>$countCart,'perfil'=>$perfil]);
    }
    public function create()
    {
        $load=load();
        $countCart=$load['countCart'];
        $perfil=$load['perfil'];
        $address=Address::where('user_id','=',''.Auth::user()->id.'')->get();
        return view('users.profiles.address',['countCart'=>$countCart,'perfil'=>$perfil,'address'=>$address]);
    }
    public function store(Request $request)
    {
        $validated=$request->validate([
            'reference'=>'required|min:5|max:145',
            'latitude'=>'required',
            'longitude'=>'required',
        ]);

        $address=new Address;
        $address->user_id=Auth::user()->id;
        $address->reference=$validated['reference'];
        $address->latitude=$validated['latitude'];
        $address->longitude=$validated['longitude'];
        $address->save();
        Session::flash('success', 'Se la direccion exitosamente');
        return redirect()->back();
    }
    public function destroy($id)
    {
        try {
            $address = Address::findOrFail($id);
            $address->delete();
            Session::flash('success', 'Se elimino la direccion');
            return redirect()->back();
       } catch (\Exception $e) {
            Session::flash('danger', 'Hubo un error inesperado');
            return redirect()->back();
       }
    }
}
