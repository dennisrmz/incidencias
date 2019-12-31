@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">

                <div class="panel-heading">Incidencias En Progreso</div>

                <div class="panel-body">
                    Primer Body
                </div>

                <div class="panel-heading">Incidencias En Espera</div>

                <div class="panel-body">
                    @foreach($incidencias as $incidencia)
                    <div class="shadow rounded card borde">
                        @foreach($usuarios as $usuario)
                            @if($usuario->id == $incidencia->usuario_asigno)
                                <h5 class="card-header">Asignada Por: {{ $usuario->name}}</h5>
                            @endif
                        @endforeach
                        <div class="card-body">
                            <h5 class="card-title">Nombre de Incidencia: {{ $incidencia->nombre }}</h5>
                            <p class="card-text">Fecha de Asignacion: {{ $incidencia->descripcion }} </p>
                            <p class="card-text">Fecha de Asignacion: {{ date('d-m-Y', strtotime($incidencia->fecha_asignacion)) }} </p>
                            <p class="card-text">Fecha de Finalizacion: {{ date('d-m-Y', strtotime($incidencia->fecha_finalizacion)) }}</p>
                            @foreach($estados as $estado)
                                @if($estado->id == $incidencia->state_id)
                                <p class="card-text">Estado: {{ $estado->nombre }}</p>
                                @endif
                            @endforeach
                            <div class="text-right">
                                <a href="{{ route('incidents.aceptar' , ['incident' => $incidencia->id, 'user' => (Auth::user()->id)]) }}" class="btn btn-primary">Aceptar Incidencia</a>
                                <a href="#" class="btn btn-secondary">Rechazar Incidencia</a>
                            </div>
                        </div>
                    </div>
                    <br>
                    @endforeach
                </div>
                <div>
                {{ $incidencias->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection