@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Incidencias Sin Aprobacion</div>

                <div class="panel-body">
                    @foreach($incidenciasNoAprobadas as $incidencia)
                    <div class="shadow rounded card borde">
                        @foreach($usuarios as $usuario)
                        @if($usuario->id == $incidencia->usuario_asigno)
                        <h5 class="card-header">Asignada Por: {{ $usuario->name}}
                            @foreach($departamentos as $departamento)
                                @if($usuario->departaments_id == $departamento->id)
                                Departamento: {{   $departamento->nombre }}
                                @endif
                            @endforeach
                        </h5>
                        @endif
                        @endforeach
                        <div class="card-body">
                            <h5 class="card-title">Nombre de Incidencia: {{ $incidencia->nombre }}</h5>
                            <h6>Usuarios a quienes se les asigno:
                                <div class="text-center">
                                @foreach($usuariosIncidencia as $usuarioIncidencia)
                                    @if($usuarioIncidencia->id == $incidencia->id)
                                     {{ $usuarioIncidencia->name }} <br> 
                                    @endif
                                @endforeach
                                </div>
                            </h6>
                            <p class="card-text">Descripcion: {{ $incidencia->descripcion }} </p>
                            <p class="card-text">Fecha de Asignacion: {{ date('d-m-Y', strtotime($incidencia->fecha_asignacion)) }} </p>
                            <p class="card-text">Fecha de Finalizacion Propuesta: {{ date('d-m-Y', strtotime($incidencia->fecha_finalizacion)) }}</p>
                            @foreach($estados as $estado)
                            @if($estado->id == $incidencia->state_id)
                            <p class="card-text">Estado: {{ $estado->nombre }}</p>
                            @endif
                            @endforeach

                            <div class="text-right">
                                <a href="{{ route('incidents.aprobar' , $incidencia->id) }}" class="btn btn-primary">Aprobar Incidencia</a>
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
                    {{ $incidenciasNoAprobadas->links() }}
                </div>
            </div>
        </div>
    </div>

<!-- Modal de Rechazo Incidencia -->
@foreach($incidenciasNoAprobadas as $incidencia)
<div class="modal fade" id="exampleModal{{ $incidencia->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Rechazo de Aprobacion</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('incidents.rechazaraprobacion', $incidencia->id) }}" method="post">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}

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
</div>
@endsection