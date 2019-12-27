<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Departament;
use App\User;
use Illuminate\Http\Request;

class DepartamentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departaments = Departament::paginate(10);

        return view('departaments.index', compact('departaments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departaments = Departament::all();



        $users = DB::table('users')
            ->join('role_user', 'users.id', 'role_user.user_id')
            ->join('roles', 'role_user.role_id', 'roles.id')
            ->select('users.name', 'users.id', 'users.es_lider')
            ->where('roles.name', 'Encargado')
            ->get()->toArray();

        return view('departaments.create', compact('users', 'departaments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Creando Entidad Departamento
        $departament = new Departament;

        //Obteniendo datos que se reciben de la vista
        $departament->nombre = $request->nombre;
        $departament->id_lider = $request->users_id;

        //metodo para guardar departamento
        $departament->save();

        //Buscando Usuario Que es seleccionado como encargado
        $user = User::find($request->users_id);

        //Asignandole a usuario que Es Encargado de Un Departamento
        $user->es_lider = 1;

        //Metodo para actualizar Usuario
        $user->update();

        return redirect()->route('departaments.edit', $departament->id)->with('info', 'Departamento Guardado con Exito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Departament  $departament
     * @return \Illuminate\Http\Response
     */
    public function show(Departament $departament)
    {
        $user = User::find($departament->id_lider);
        
        
        return view('departaments.show', compact('departament', 'user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Departament  $departament
     * @return \Illuminate\Http\Response
     */
    public function edit(Departament $departament)
    {
        $departaments = Departament::all();

        $users = DB::table('users')
            ->join('role_user', 'users.id', 'role_user.user_id')
            ->join('roles', 'role_user.role_id', 'roles.id')
            ->select('users.name', 'users.id', 'users.es_lider')
            ->where('roles.name', 'Encargado')
            ->get()->toArray();
        return view('departaments.edit', compact('departament', 'users', 'departaments'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Departament  $departament
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Departament $departament)
    {
        

        Departament::find($departament->id)->update($request->all());

        $users = User::find($request->anterior);

        //Asignandole a usuario que Es Encargado de Un Departamento
        $users->es_lider = 0;

        //Metodo para actualizar Usuario
        $users->update();

        $user = User::find($request->id_lider);

        //Asignandole a usuario que Es Encargado de Un Departamento
        $user->es_lider = 1;

        //Metodo para actualizar Usuario
        $user->update();

        

        


        return redirect()->route('departaments.edit', $departament->id)->with('info', 'Departamento Actualizado con Exito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Departament  $departament
     * @return \Illuminate\Http\Response
     */
    public function destroy(Departament $departament)
    {
        $departament->delete();

        $user = User::find($departament->id_lider);

        //Asignandole a usuario que Es Encargado de Un Departamento
        $user->es_lider = 0;

        //Metodo para actualizar Usuario
        $user->update();

        return back()->with('info', 'Eliminado Correctamente');
    }
}
