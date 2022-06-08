<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Products;
use Illuminate\Http\Request;
use App\Http\Requests\SaveFormUser;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(){
        $this->middleware('admin');
    }

    public function index(){

        return view('admin.panel');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(User $user,SaveFormUser $request)
    {
        $validate=$request->validated();


        $user =new User;
        $user->name = $validate['nombre'];
        $user->password = bcrypt($validate['password']);
        $user->role = 'ADMIN';
        $user->email = $validate['email'];
        $user->perfil='ad.png';

        $user->save();
        return redirect()->route('home')->with('success','Registro con exito');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('users.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(User $user,SaveFormUser $request)
    {


        $validate=$request->validated();

        $user->name = $validate['name'];
        $user->password = bcrypt($validate['password']);
        $user->email = $validate['email'];

        $user->save();

        return redirect()->route('inicio')->with('success','Registro con exito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $user = User::findOrFail($project->id);
        $user->destroy($project->id);

        return redirect()->back()->with('success','Eliminacion con exito');
    }
}
