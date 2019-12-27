<?php

namespace App\Http\Controllers;

use Caffeinated\Shinobi\Models\Role;
use Caffeinated\Shinobi\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     //Ver Roles
    public function index()
    {
        $roles = Role::paginate(10);

        return view('roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

     //Vista para Crear el Rol
    public function create()
    {
        $permissions = Permission::get();

        return view('roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    //Funcion para guardar el rol
    public function store(Request $request)
    {
        //dd($request);
        $role = new Role;

        $role->name = $request->name;
        $role->slug = $request->slug;
        $role->description = $request->description;
        $role->save();

        //Actualizar Permisos
        //sync palabra reservada para guardar en tablas intermedias
        $role->permissions()->sync($request->get('permissions'));

        return redirect()->route('roles.edit', $role->id)->with('info', 'Rol Guardado con Exito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */

     //Funcion Para ver Rol
    public function show(Role $role)
    {
        return view('roles.show')->with('role', $role);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */

     //Vista para editar el rol
    public function edit(Role $role)
    {
        $permissions = Permission::get();

        return view('roles.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */

     //funcion para editar el rol
    public function update(Request $request, Role $role)
    {  

        //Actualizar Rol
        Role::find($role->id)->update($request->all());

        //Actualizar Permisos
        $role->permissions()->sync($request->get('permissions'));

        return redirect()->route('roles.edit', $role->id)->with('info', 'Rol Actualizado con Exito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */

     //funcion para eliminar el rol
    public function destroy(Role $role)
    {
        $role->delete();

        return back()->with('info', 'Eliminado Correctamente');
    }
}
