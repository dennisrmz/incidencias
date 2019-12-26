<?php

namespace App\Http\Controllers;

use App\Departament;
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
        return view('departaments.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $departament = new Departament;

        $departament->nombre = $request->nombre;
        $departament->id_lider = 1;
        $departament->save();
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
        return view('departaments.show')->with('departament', $departament);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Departament  $departament
     * @return \Illuminate\Http\Response
     */
    public function edit(Departament $departament)
    {
        return view('departaments.edit', compact('departament'));
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

        return back()->with('info', 'Eliminado Correctamente');
    }
}
