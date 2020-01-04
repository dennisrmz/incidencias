@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Incidencias Finalizadas</div>

                <div class="panel-body">
                    @foreach($incidenciasFinalizadas as $incidencia)
                    <div class="shadow rounded card borde">
                        @foreach($usuarios as $usuario)
                        @if($usuario->id == $incidencia->usuario_asigno)
                        <h5 class="card-header">Asignada Por: {{ $usuario->name}}</h5>
                        @endif
                        @endforeach
                        <div class="card-body">
                            <h5 class="card-title">Nombre de Incidencia: {{ $incidencia->nombre }}</h5>
                            <p class="card-text">Descripcion: {{ $incidencia->descripcion }} </p>
                            <p class="card-text">Observaciones: {{ $incidencia->observaciones }} </p>
                            <p class="card-text">Fecha de Asignacion: {{ date('d-m-Y', strtotime($incidencia->fecha_asignacion)) }} </p>
                            <p class="card-text">Fecha de Aceptacion: {{ date('d-m-Y', strtotime($incidencia->fecha_aceptacion)) }} </p>
                            <p class="card-text">Fecha de Finalizacion Propuesta: {{ date('d-m-Y', strtotime($incidencia->fecha_finalizacion)) }}</p>
                            <p class="card-text">Fecha de Finalizacion: {{ date('d-m-Y', strtotime($incidencia->fecha_finalizacion_user)) }}</p>
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
                    {{ $incidenciasFinalizadas->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection