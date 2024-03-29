<?php

namespace App\Http\Controllers;

use App\Departament;
use App\Equipment;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $equipments = Equipment::paginate(10);
      


        return view('equipments.index', compact('equipments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departaments = Departament::all();

        return view('equipments.create', compact('departaments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $equipment = new Equipment;

        $equipment->nombre = $request->nombre;
        $equipment->departaments_id = $request->departaments_id;
        $equipment->save();
        return redirect()->route('equipments.edit', $equipment->id)->with('info', 'Equipo guardado con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Equipment  $equipment
     * @return \Illuminate\Http\Response
     */
    public function show(Equipment $equipment)
    {
        return view('equipments.show')->with('equipment', $equipment);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Equipment  $equipment
     * @return \Illuminate\Http\Response
     */
    public function edit(Equipment $equipment)
    {
        return view('equipments.edit', compact('equipment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Equipment  $equipment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Equipment $equipment)
    {
        Equipment::find($equipment->id)->update($request->all());

        return redirect()->route('equipments.edit', $equipment->id)->with('info', 'Equipo actualizado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Equipment  $equipment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Equipment $equipment)
    {
        $equipment->delete();

        return back()->with('info', 'Eliminado Correctamente');
    }

    public function getEquipment(Request $request)
    {
        if ($request->ajax()){
           $equipos = Equipment::where('departaments_id', $request->departamento_id)->get();
           $equiposArray = array();

           foreach($equipos as $equipo){
               $equiposArray[$equipo->id] = $equipo->nombre;
           }
           
           return response()->json($equiposArray);
        }
    }
}