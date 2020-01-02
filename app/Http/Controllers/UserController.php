<?php

namespace App\Http\Controllers;

use App\Departament;
use App\Equipment;
use App\User;
use Caffeinated\Shinobi\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::paginate(10);

        return view('users.index', compact('users'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('users.show')->with('user', $user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $roles = Role::get();

        $rolesuser = DB::table('role_user')
        ->select('role_user.role_id')
        ->where('role_user.user_id', $user->id)
        ->get()->toArray();

        $departaments = Departament::get();

        $equipments = Equipment::get();

        return view('users.edit', compact('user', 'roles', 'rolesuser', 'departaments', 'equipments'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {  
        User::find($user->id)->update($request->all());

        $user->roles()->sync($request->get('roles'));

        return redirect()->route('users.edit', $user->id)->with('info', 'Usuario Actualizado con Exito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return back()->with('info', 'Eliminado Correctamente');
    }

    public function getUser(Request $request)
    {
        if ($request->ajax()){
            $usuarios = User::where('equipments_id', $request->equipo_id)->get();
            
            foreach($usuarios as $usuario){
                $usuariosArray[$usuario->id] = $usuario->name;
            }
         return response()->json($usuariosArray);
         }
    }

    public function getUserDepartament(Request $request)
    {
        if ($request->ajax()){
            $usuarios = User::where('departaments_id', $request->seleccion)->get();
            
            foreach($usuarios as $usuario){
                $usuariosArray[$usuario->id] = [$usuario->name, $usuario->es_lider];
            }
         return response()->json($usuariosArray);
         }
    }
    
}
