@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">

                <div class="panel-heading">Incidencias En Progreso</div>

                <div class="panel-body">
                    @foreach($incidenciaProgreso as $incidencia)
                    <div class="shadow rounded card borde">
                        @foreach($usuarios as $usuario)
                        @if($usuario->id == $incidencia->usuario_asigno)
                        <h5 class="card-header">Asignada Por: {{ $usuario->name}}</h5>
                        @endif
                        @endforeach
                        <div class="card-body">
                            <h5 class="card-title">Nombre de Incidencia: {{ $incidencia->nombre }}</h5>
                            <p class="card-text">Descripcion: {{ $incidencia->descripcion }} </p>
                            <p class="card-text">Fecha de Asignacion: {{ date('d-m-Y', strtotime($incidencia->fecha_asignacion)) }} </p>
                            <p class="card-text">Fecha de Finalizacion: {{ date('d-m-Y', strtotime($incidencia->fecha_finalizacion)) }}</p>
                            @foreach($estados as $estado)
                            @if($estado->id == $incidencia->state_id)
                            <p class="card-text">Estado: {{ $estado->nombre }}</p>
                            @endif
                            @endforeach
                            <div class="text-right">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                    Finalizar Incidencia
                                </button>
                            </div>
                        </div>
                    </div>
                    <br>
                    @endforeach
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
                            <p class="card-text">Descripcion: {{ $incidencia->descripcion }} </p>
                            <p class="card-text">Fecha de Asignacion: {{ date('d-m-Y', strtotime($incidencia->fecha_asignacion)) }} </p>
                            <p class="card-text">Fecha de Finalizacion: {{ date('d-m-Y', strtotime($incidencia->fecha_finalizacion)) }}</p>
                            @foreach($estados as $estado)
                            @if($estado->id == $incidencia->state_id)
                            <p class="card-text">Estado: {{ $estado->nombre }}</p>
                            @endif
                            @endforeach
                            <div class="text-right">
                                <a href="{{ route('incidents.aceptar' , ['incident' => $incidencia->id, 'user' => (Auth::user()->id)]) }}" class="btn btn-primary">Aceptar Incidencia</a>
                                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#exampleModal{{$incidencia->id}}">
                                    Rechazar Incidencia
                                </button>
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

<!-- Modal de Finalizacion Incidencia -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Finalizar Incidencia</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('incidents.finalizar', Auth::user()->id) }}" method="post">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    @foreach($incidenciaProgreso as $incidencia)
                    <div style="display: none">
                        <input type="text" name="incident_id" value="{{ $incidencia->id }}">
                    </div>
                    <div class="form-group">
                        <label>Observaciones</label>
                        <input type="text" name="observaciones" class="form-control" required>
                    </div>
                    @endforeach

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Finalizar Incidencia</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Rechazo Incidencia -->
@foreach($incidencias as $incidencia)
<div class="modal fade" id="exampleModal{{ $incidencia->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('incidents.rechazar', Auth::user()->id) }}" method="post">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}

                    <div style="display: none">
                        <input type="text" name="incident_id" value="{{ $incidencia->id }}">
                    </div>

                    <div class="form-group">
                        <label>Motivo de Rechazo</label>
                        <input type="text" name="descripcion_rechazo" class="form-control" placeholder="Digite el motivo de rechazo" required>
                    </div>


                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Rechazar Incidencias</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
@endforeach
@endsection