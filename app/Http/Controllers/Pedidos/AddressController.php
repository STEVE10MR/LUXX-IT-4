<?php

namespace App\Http\Controllers\Pedidos;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;

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
        try
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
            return redirect()->back()->with('success', 'Direccion Agregada');
        }catch (\Exception $e) {
            return redirect()->back()->with('error', 'Hubo un error al agregar la direccion');
        }
    }
    public function destroy($id)
    {
        try {
            $address = Address::findOrFail($id);
            $address->delete();
            return redirect()->back()->with('success', 'Se elimino la direccion');
        }catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
