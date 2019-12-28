<?php

namespace App\Http\Controllers;

use App\Incident;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class IncidentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $users = DB::table('users')
        ->join('role_user', 'users.id', 'role_user.user_id')
        ->join('roles', 'role_user.role_id', 'roles.id')
        ->select('users.name', 'users.id', 'users.es_lider')
        ->where('roles.name', 'Encargado')
        ->get()->toArray();

        $rolesusuarios = DB::table('role_user')
        ->select('role_user.id', 'role_user.role_id', 'role_user.user_id')
        ->get()->toArray();

        return view('incidents.create', compact('users', 'rolesusuarios'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $incidencia = new Incident;

        $codigo0 = mt_rand(0,9);
        $codigo1 = mt_rand(0,9);
        $codigo2 = mt_rand(0,9);
        $codigo3 = mt_rand(0,9);
        $codigo4 = mt_rand(0,9);
        $codigo5 = mt_rand(0,9);
        $codigoInc = $codigo0."".$codigo1."".$codigo2."".$codigo3."".$codigo4."".$codigo5;
        

        $incidencia->nombre = $request->nombre;
        $incidencia->descripcion = $request->descripcion;
        $incidencia->usuario_asigno = $request->usuario_asigno;
        $incidencia->codigo = $codigoInc;
        $incidencia->estado_aprobacion = 1;
        $incidencia->fecha_asignacion = Carbon::now();
        $incidencia->save(); 

       
        $incidencia->users()->sync($request->get('user_id'));

        
        return redirect()->route('incidents.edit', $incidencia->id)->with('info', 'Incidencia Guardada con Exito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Incident  $incident
     * @return \Illuminate\Http\Response
     */
    public function show(Incident $incident)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Incident  $incident
     * @return \Illuminate\Http\Response
     */
    public function edit(Incident $incident)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Incident  $incident
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Incident $incident)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Incident  $incident
     * @return \Illuminate\Http\Response
     */
    public function destroy(Incident $incident)
    {
        //
    }
}
