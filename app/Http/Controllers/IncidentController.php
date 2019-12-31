<?php

namespace App\Http\Controllers;

use App\Incident;
use App\State;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use DateTime;

class IncidentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        return view('incidents.index');
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

        $codigo0 = mt_rand(0, 9);
        $codigo1 = mt_rand(0, 9);
        $codigo2 = mt_rand(0, 9);
        $codigo3 = mt_rand(0, 9);
        $codigo4 = mt_rand(0, 9);
        $codigo5 = mt_rand(0, 9);
        $codigoInc = $codigo0 . "" . $codigo1 . "" . $codigo2 . "" . $codigo3 . "" . $codigo4 . "" . $codigo5;

        $incidencia->nombre = $request->nombre;
        $incidencia->descripcion = $request->descripcion;
        $incidencia->usuario_asigno = $request->usuario_asigno;
        $incidencia->codigo = $codigoInc;
        $incidencia->estado_aprobacion = 1;
        $incidencia->fecha_asignacion = Carbon::now();
        $incidencia->save();
        $fechaSinFormato = $request->fecha_finalizacion;
        $fechaDB = DateTime::createFromFormat("d/m/Y", $fechaSinFormato);


        foreach ($request->user_id as $iteracion => $v) {
            $datos = array(
                $request->user_id[$iteracion] => [
                    'fecha_finalizacion' => $fecha_finalizacion[$iteracion] = (DateTime::createFromFormat("d/m/Y", $request->fecha_finalizacion)),
                ]
            );
            $incidencia->users()->attach($datos);
        }
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

    public function obteniendoIncidencias(User $user)
    {
        $incidenciaProgreso = DB::table('incidents')
            ->join('user_incident', 'incidents.id', 'user_incident.incident_id')
            ->join('users', 'user_incident.user_id', 'users.id')
            ->select('incidents.id', 'incidents.usuario_asigno', 'incidents.descripcion', 'incidents.nombre', 'incidents.fecha_asignacion', 'user_incident.fecha_finalizacion', 'user_incident.state_id')
            ->where('users.id', $user->id)
            ->where('incidents.estado_aprobacion', 1)
            ->where('user_incident.state_id', 2)
            ->get();

        $incidencias = DB::table('incidents')
            ->join('user_incident', 'incidents.id', 'user_incident.incident_id')
            ->join('users', 'user_incident.user_id', 'users.id')
            ->select('incidents.id', 'incidents.usuario_asigno', 'incidents.descripcion', 'incidents.nombre', 'incidents.fecha_asignacion', 'user_incident.fecha_finalizacion', 'user_incident.state_id')
            ->where('users.id', $user->id)
            ->where('incidents.estado_aprobacion', 1)
            ->where('user_incident.state_id', 1)
            ->paginate(5);

        $usuarios = User::get();
        $estados = State::get();
        return view('incidents.incidencias')->with('info', 0)->with('incidencias', $incidencias)->with('usuarios', $usuarios)->with('estados', $estados)->with('incidenciaProgreso', $incidenciaProgreso);
    }

    /****** Funcion para Cambiar Estado De Incidencia a Aceptada ***************************************************/
    public function aceptarIncidencia(Request $request, Incident $incident, User $user)
    {

        $incidencias = DB::table('incidents')
            ->join('user_incident', 'incidents.id', 'user_incident.incident_id')
            ->join('users', 'user_incident.user_id', 'users.id')
            ->select('incidents.id', 'user_incident.state_id')
            ->where('users.id', $user->id)
            ->where('incidents.estado_aprobacion', 1)
            ->where('user_incident.state_id', 2)
            ->get();

        if (count($incidencias) == 0) {

            DB::table('user_incident')
                ->where('user_incident.user_id', $user->id)
                ->where('user_incident.incident_id', $incident->id)
                ->update(['user_incident.state_id' => 2, 'user_incident.fecha_aceptacion' =>  Carbon::now()]);

            $incidencias = DB::table('incidents')
                ->join('user_incident', 'incidents.id', 'user_incident.incident_id')
                ->join('users', 'user_incident.user_id', 'users.id')
                ->select('incidents.id', 'incidents.usuario_asigno', 'incidents.descripcion', 'incidents.nombre', 'incidents.fecha_asignacion', 'user_incident.fecha_finalizacion', 'user_incident.state_id')
                ->where('users.id', $user->id)
                ->where('incidents.estado_aprobacion', 1)
                ->where('user_incident.state_id', 1)
                ->paginate(5);

            $incidenciaProgreso = DB::table('incidents')
                ->join('user_incident', 'incidents.id', 'user_incident.incident_id')
                ->join('users', 'user_incident.user_id', 'users.id')
                ->select('incidents.id', 'incidents.usuario_asigno', 'incidents.descripcion', 'incidents.nombre', 'incidents.fecha_asignacion', 'user_incident.fecha_finalizacion', 'user_incident.state_id')
                ->where('users.id', $user->id)
                ->where('incidents.estado_aprobacion', 1)
                ->where('user_incident.state_id', 2)
                ->get();


            $usuarios = User::get();
            $estados = State::get();
            return redirect()->route('incidents.incidencias', ['user' => $user->id])->with('info', 'Incidencia En Progreso')->with('incidencias', $incidencias)->with('usuarios', $usuarios)->with('estados', $estados)->with('incidenciaProgreso', $incidenciaProgreso);
        } else {

            $incidencias = DB::table('incidents')
                ->join('user_incident', 'incidents.id', 'user_incident.incident_id')
                ->join('users', 'user_incident.user_id', 'users.id')
                ->select('incidents.id', 'incidents.usuario_asigno', 'incidents.descripcion', 'incidents.nombre', 'incidents.fecha_asignacion', 'user_incident.fecha_finalizacion', 'user_incident.state_id')
                ->where('users.id', $user->id)
                ->where('incidents.estado_aprobacion', 1)
                ->where('user_incident.state_id', 1)
                ->paginate(5);

            $incidenciaProgreso = DB::table('incidents')
                ->join('user_incident', 'incidents.id', 'user_incident.incident_id')
                ->join('users', 'user_incident.user_id', 'users.id')
                ->select('incidents.id', 'incidents.usuario_asigno', 'incidents.descripcion', 'incidents.nombre', 'incidents.fecha_asignacion', 'user_incident.fecha_finalizacion', 'user_incident.state_id')
                ->where('users.id', $user->id)
                ->where('incidents.estado_aprobacion', 1)
                ->where('user_incident.state_id', 2)
                ->get();

            $usuarios = User::get();
            $estados = State::get();
            return redirect()->route('incidents.incidencias', ['user' => $user->id])->with('danger', ' Ya posee una incidencia en progreso debe finalizarla, para poner una nueva en progreso.')->with('incidencias', $incidencias)->with('usuarios', $usuarios)->with('estados', $estados)->with('incidenciaProgreso', $incidenciaProgreso);
        }
    }
    /************************************************************************************************* */

    /****** Funcion para Cambiar Estado De Incidencia a Finalizada ***************************************************/
    public function finalizarIncidencia(Request $request, User $user)
    {
        DB::table('user_incident')
            ->where('user_incident.user_id', $user->id)
            ->where('user_incident.incident_id', $request->incident_id)
            ->update(['observaciones' => $request->observaciones, 'user_incident.state_id' => 3, 'user_incident.fecha_finalizacion_user' =>  Carbon::now()]);

        return redirect()->route('incidents.incidencias', ['user' => $user->id])->with('info', 'Incidencia finalizada, puede aceptar una nueva');
    }

    /************************************************************************************************* */

    /****** Funcion para Cambiar Estado De Incidencia a Finalizada ***************************************************/

    public function rechazarIncidencia(Request $request, User $user)
    {
        DB::table('user_incident')
            ->where('user_incident.user_id', $user->id)
            ->where('user_incident.incident_id', $request->incident_id)
            ->update(['descripcion_rechazo' => $request->descripcion_rechazo, 'user_incident.state_id' => 4, 'user_incident.fecha_rechazo' =>  Carbon::now()]);

        return redirect()->route('incidents.incidencias', ['user' => $user->id])->with('danger', 'Incidencia Rechazada');
    }


    public function mostrarIncidenciasRechazadas()
    {
        
    }
}
