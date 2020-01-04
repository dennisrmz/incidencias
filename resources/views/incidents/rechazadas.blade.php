@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Incidencias Rechazadas</div>

                <div class="panel-body">
                    @foreach($incidenciasRechazadas as $incidencia)
                    <div class="shadow rounded card borde">
                        @foreach($usuarios as $usuario)
                        @if($usuario->id == $incidencia->usuario_asigno)
                        <h5 class="card-header">Asignada Por: {{ $usuario->name}}</h5>
                        @endif
                        @endforeach
                        <div class="card-body">
                            <h5 class="card-title">Nombre de Incidencia: {{ $incidencia->nombre }}</h5>
                            <p class="card-text">Descripcion: {{ $incidencia->descripcion }} </p>
                            <p class="card-text">Motivo de Rechazo: {{ $incidencia->descripcion_rechazo }} </p>
                            <p class="card-text">Fecha de Asignacion: {{ date('d-m-Y', strtotime($incidencia->fecha_asignacion)) }} </p>
                            <p class="card-text">Fecha de Rechazo: {{ date('d-m-Y', strtotime($incidencia->fecha_rechazo)) }}</p>
                            @foreach($estados as $estado)
                            @if($estado->id == $incidencia->state_id)
                            <p class="card-text">Estado: {{ $estado->nombre }}</p>
                            @endif
                            @endforeach
                        </div>
                    </div>
                    <br>
                    @endforeach
                </div>
                <div>
                    {{ $incidenciasRechazadas->links() }}
                </div>
            </div>
            @can('incidents.create')
            <div class="panel panel-default">

                <div class="panel-heading">Incidencias No Aprobadas</div>

                <div class="panel-body">
                    @foreach($incidenciasNoAprobadas as $incidencia)
                    <div class="shadow rounded card borde">
                        @foreach($usuarios as $usuario)
                        @if($usuario->id == $incidencia->usuario_asigno)
                        <h5 class="card-header">Asignada Por: {{ $usuario->name}}</h5>
                        @endif
                        @endforeach
                        <div class="card-body">
                            <h5 class="card-title">Nombre de Incidencia: {{ $incidencia->nombre }}</h5>
                            <p class="card-text">Descripcion: {{ $incidencia->descripcion }} </p>
                            <p class="card-text">Motivo de Rechazo: {{ $incidencia->descripcion_rechazo }} </p>
                            <p class="card-text">Fecha de Asignacion: {{ date('d-m-Y', strtotime($incidencia->fecha_asignacion)) }} </p>
                            <p class="card-text">Fecha de Rechazo: {{ date('d-m-Y', strtotime($incidencia->fecha_rechazo)) }}</p>
                            @foreach($estados as $estado)
                            @if($estado->id == $incidencia->state_id)
                            <p class="card-text">Estado: {{ $estado->nombre }}</p>
                            @endif
                            @endforeach
                        </div>
                    </div>
                    <br>
                    @endforeach
                </div>
                <div>
                    {{ $incidenciasNoAprobadas->links() }}
                </div>
            </div>
            @endcan
        </div>
    </div>
</div>
@endsection