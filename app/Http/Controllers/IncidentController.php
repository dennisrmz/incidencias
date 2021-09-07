<?php

namespace App\Http\Controllers;

use App\Departament;
use App\Equipment;
use App\Incident;
use App\State;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use DateTime;
use PDF;

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

        $departaments = Departament::get();

        return view('incidents.create', compact('users', 'rolesusuarios', 'departaments'));
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
        $incidencia->fecha_asignacion = Carbon::now('America/El_Salvador');
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
        return back()->with('info', 'Incidencia Guardada con Exito');
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
                ->update(['state_id' => 2, 'fecha_aceptacion' =>  Carbon::now('America/El_Salvador')]);

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
            ->update(['observaciones' => $request->observaciones, 'state_id' => 3, 'fecha_finalizacion_user' =>  Carbon::now('America/El_Salvador')]);

        return redirect()->route('incidents.incidencias', ['user' => $user->id])->with('info', 'Incidencia finalizada, puede aceptar una nueva');
    }

    /************************************************************************************************* */

    /****** Funcion para Cambiar Estado De Incidencia a Rechazada ***************************************************/

    public function rechazarIncidencia(Request $request, User $user)
    {
        DB::table('user_incident')
            ->where('user_incident.user_id', $user->id)
            ->where('user_incident.incident_id', $request->incident_id)
            ->update(['descripcion_rechazo' => $request->descripcion_rechazo, 'state_id' => 4, 'fecha_rechazo' =>  Carbon::now('America/El_Salvador')]);

        return redirect()->route('incidents.incidencias', ['user' => $user->id])->with('danger', 'Incidencia Rechazada');
    }


    public function mostrarIncidenciasRechazadas(User $user)
    {
        $incidenciasRechazadas = DB::table('incidents')
            ->join('user_incident', 'incidents.id', 'user_incident.incident_id')
            ->join('users', 'user_incident.user_id', 'users.id')
            ->select('incidents.id', 'incidents.usuario_asigno', 'incidents.descripcion', 'incidents.nombre', 'incidents.fecha_asignacion', 'user_incident.fecha_rechazo', 'user_incident.state_id', 'user_incident.descripcion_rechazo')
            ->where('users.id', $user->id)
            ->where('incidents.estado_aprobacion', 1)
            ->where('user_incident.state_id', 4)
            ->paginate(5);

        $incidenciasNoAprobadas = DB::table('incidents')
            ->join('user_incident', 'incidents.id', 'user_incident.incident_id')
            ->join('users', 'user_incident.user_id', 'users.id')
            ->select('incidents.id', 'incidents.usuario_asigno', 'incidents.descripcion', 'incidents.nombre', 'incidents.fecha_asignacion', 'user_incident.fecha_finalizacion', 'user_incident.state_id', 'user_incident.descripcion_rechazo', 'user_incident.fecha_rechazo')
            ->where('users.departaments_id', $user->departaments_id)
            ->where('incidents.estado_aprobacion', false)
            ->where('user_incident.state_id', 4)
            ->distinct('incidents.id')
            ->paginate(5);

        $usuarios = User::get();
        $estados = State::get();

        return view('incidents.rechazadas')->with('incidenciasNoAprobadas', $incidenciasNoAprobadas)->with('incidenciasRechazadas', $incidenciasRechazadas)->with('usuarios', $usuarios)->with('estados', $estados);
    }

    public function mostrarIncidenciasFinalizadas(User $user)
    {
        $incidenciasFinalizadas = DB::table('incidents')
            ->join('user_incident', 'incidents.id', 'user_incident.incident_id')
            ->join('users', 'user_incident.user_id', 'users.id')
            ->select('incidents.id', 'incidents.usuario_asigno', 'incidents.descripcion', 'incidents.nombre', 'incidents.fecha_asignacion', 'user_incident.fecha_finalizacion', 'user_incident.fecha_finalizacion_user', 'user_incident.fecha_aceptacion', 'user_incident.state_id', 'user_incident.observaciones')
            ->where('users.id', $user->id)
            ->where('incidents.estado_aprobacion', 1)
            ->where('user_incident.state_id', 3)
            ->paginate(5);

        $usuarios = User::get();
        $estados = State::get();

        return view('incidents.finalizadas')->with('incidenciasFinalizadas', $incidenciasFinalizadas)->with('usuarios', $usuarios)->with('estados', $estados);
    }

    public function storeLider(Request $request)
    {
        if ($request->form_seleccion == 2) {
            $incidencia = new Incident;

            $codigo0 = mt_rand(0, 9);
            $codigo1 = mt_rand(0, 9);
            $codigo2 = mt_rand(0, 9);
            $codigo3 = mt_rand(0, 9);
            $codigo4 = mt_rand(0, 9);
            $codigo5 = mt_rand(0, 9);
            $codigoInc = $codigo0 . "" . $codigo1 . "" . $codigo2 . "" . $codigo3 . "" . $codigo4 . "" . $codigo5;

            $incidencia->nombre = $request->nombreIncidencia;
            $incidencia->descripcion = $request->descripcionIncidencia;
            $incidencia->usuario_asigno = $request->usuario_asignoIncidencia;
            $incidencia->codigo = $codigoInc;
            $usuario = User::where('id', $request->usuario_asignoIncidencia)->get();
            $equipo = Equipment::where('id', $request->equipments_idIncidencia)->get();
            if ($usuario[0]->departaments_id == $equipo[0]->departaments_id) {
                $incidencia->estado_aprobacion = 1;
            } else {
                $incidencia->estado_aprobacion = 0;
            }
            $incidencia->fecha_asignacion = Carbon::now('America/El_Salvador');
            $incidencia->save();

            $usuarios = User::where('equipments_id', $request->equipments_idIncidencia)->get();

            foreach ($usuarios as $usuario) {
                DB::table('user_incident')->insert(['user_id' => $usuario->id, 'incident_id' => $incidencia->id, 'state_id' => 1, 'fecha_finalizacion' => (DateTime::createFromFormat("d/m/Y", $request->fecha_finalizacionIncidencia))]);
            }
            return redirect()->route('home')->with('info', 'Incidencia Guardada con Exito');
        } elseif ($request->form_seleccion == 1) {
            $incidencia = new Incident;

            $codigo0 = mt_rand(0, 9);
            $codigo1 = mt_rand(0, 9);
            $codigo2 = mt_rand(0, 9);
            $codigo3 = mt_rand(0, 9);
            $codigo4 = mt_rand(0, 9);
            $codigo5 = mt_rand(0, 9);
            $codigoInc = $codigo0 . "" . $codigo1 . "" . $codigo2 . "" . $codigo3 . "" . $codigo4 . "" . $codigo5;
            $incidencia->nombre = $request->nombreIncidencia;
            $incidencia->descripcion = $request->descripcionIncidencia;
            $incidencia->usuario_asigno = $request->usuario_asignoIncidencia;
            $incidencia->codigo = $codigoInc;
            $usuarioAsigno = User::where('id', $request->usuario_asignoIncidencia)->get();
            $usuarioAsignado = User::where('id', $request->user_idIncidencia)->get();
            if ($usuarioAsigno[0]->departaments_id == $usuarioAsignado[0]->departaments_id) {
                $incidencia->estado_aprobacion = 1;
            } else {
                $incidencia->estado_aprobacion = 0;
            }
            $incidencia->fecha_asignacion = Carbon::now('America/El_Salvador');
            $incidencia->save();

            DB::table('user_incident')->insert(['user_id' => $request->user_idIncidencia, 'incident_id' => $incidencia->id, 'state_id' => 1, 'fecha_finalizacion' => (DateTime::createFromFormat("d/m/Y", $request->fecha_finalizacionIncidencia))]);
            return redirect()->route('home')->with('info', 'Incidencia Guardada con Exito');
        }
    }

    public function mostrarIncidenciasConFaltaAprobacion(User $user)
    {

        $incidenciasNoAprobadas = DB::table('incidents')
            ->join('user_incident', 'incidents.id', 'user_incident.incident_id')
            ->join('users', 'user_incident.user_id', 'users.id')
            ->select('incidents.id', 'incidents.usuario_asigno', 'incidents.descripcion', 'incidents.nombre', 'incidents.fecha_asignacion', 'user_incident.fecha_finalizacion', 'user_incident.state_id')
            ->where('users.departaments_id', $user->departaments_id)
            ->where('incidents.estado_aprobacion', false)
            ->where('user_incident.state_id', 1)
            ->distinct('incidents.id')
            ->paginate(5);

        $usuariosIncidencia = DB::table('incidents')
            ->join('user_incident', 'incidents.id', 'user_incident.incident_id')
            ->join('users', 'user_incident.user_id', 'users.id')
            ->select('incidents.id', 'user_incident.user_id', 'users.name')
            ->where('users.departaments_id', $user->departaments_id)
            ->where('incidents.estado_aprobacion', false)
            ->where('user_incident.state_id', 1)
            ->get()->toArray();

        $usuarios = User::get();
        $estados = State::get();
        $departamentos = Departament::get();

        return view('incidents.sinaprobacion', compact('incidenciasNoAprobadas', 'usuarios', 'estados', 'departamentos', 'usuariosIncidencia'));
    }


    public function aprobarIncidencia(Incident $incident)
    {
        DB::table('incidents')
            ->where('id', $incident->id)
            ->update(['estado_aprobacion' => true]);
        return back();
    }

    public function rechazarAprobacionIncidencia(Request $request, Incident $incident)
    {

        DB::table('user_incident')
            ->where('incident_id', $incident->id)
            ->update(['state_id' => 4, 'descripcion_rechazo' => $request->descripcion_rechazo, 'fecha_rechazo' => Carbon::now('America/El_Salvador')]);
        return back();
    }

    public function noaprobadasIncidencia(User $user){

        $incidenciasNoAprobadas = DB::table('incidents')
            ->join('user_incident', 'incidents.id', 'user_incident.incident_id')
            ->join('users', 'user_incident.user_id', 'users.id')
            ->select('incidents.id','user_incident.incident_id', 'incidents.descripcion', 'incidents.nombre', 'incidents.fecha_asignacion', 'user_incident.fecha_finalizacion', 'user_incident.state_id', 'user_incident.descripcion_rechazo', 'user_incident.fecha_rechazo')
            ->where('incidents.usuario_asigno', $user->id)
            ->where('incidents.estado_aprobacion', false)
            ->where('user_incident.state_id', 4)
            ->distinct()
            ->paginate(5);

            $usuarios = User::get();
            $estados = State::get();
            $departamentos = Departament::get();
    
            return view('incidents.noaprobadas', compact('incidenciasNoAprobadas', 'usuarios', 'estados', 'departamentos'));
        
    }

    public function asignadasenespera(User $user){

        $incidenciasEnEspera = DB::table('incidents')
        ->join('user_incident', 'incidents.id', 'user_incident.incident_id')
        ->join('users', 'user_incident.user_id', 'users.id')
        ->select('incidents.id', 'user_incident.user_id' ,'user_incident.incident_id', 'incidents.descripcion', 'incidents.nombre', 'incidents.fecha_asignacion', 'user_incident.fecha_finalizacion', 'user_incident.state_id')
        ->where('incidents.usuario_asigno', $user->id)
        ->where('incidents.estado_aprobacion', 1)
        ->where('user_incident.state_id', 1)
        ->orderBy('incidents.fecha_asignacion', 'desc')
        ->paginate(5);

        $usuarios = User::get();
        $estados = State::get();

        return view('incidents.incidenciasasignadasespera', compact('incidenciasEnEspera', 'usuarios', 'estados'));
    }

    public function generarPDF(user $user, Request $request){

        if($request->fecha_inicio < $request->fecha_fin){
            $incidenciasEnEspera = DB::table('incidents')
        ->join('user_incident', 'incidents.id', 'user_incident.incident_id')
        ->join('users', 'user_incident.user_id', 'users.id')
        ->select('incidents.id', 'user_incident.user_id' ,'user_incident.incident_id', 'incidents.descripcion', 'incidents.nombre', 'incidents.fecha_asignacion', 'user_incident.fecha_finalizacion', 'user_incident.state_id')
        ->where('incidents.usuario_asigno', $user->id)
        ->where('incidents.estado_aprobacion', 1)
        ->where('user_incident.state_id', 1)
        ->whereBetween('incidents.fecha_asignacion', [$request->fecha_inicio, $request->fecha_fin])
        ->orderBy('incidents.fecha_asignacion', 'desc')
        ->get();
        

        $usuarios = User::get();
        $estados = State::get();
        $pdf = PDF::loadView('incidents.pdfenespera', compact('incidenciasEnEspera', 'usuarios', 'estados'));
        return $pdf->download('incidenciasEnEspera.pdf');
        }else{
            return back()->with('danger', 'La fecha de inicio debe ser menor, a la fecha de fin');
        }
    }
}
