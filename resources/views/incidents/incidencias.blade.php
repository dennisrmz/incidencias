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
                    <div class="shadow rounded card borde">
                        <h5 class="card-header">Asignada Por:</h5>
                        <div class="card-body">
                            <h5 class="card-title">Nombre de Incidencia</h5>
                            <p class="card-text">Departamento que realizado la incidencia</p>
                            <p class="card-text">Fecha de Asignacion</p>
                            <p class="card-text">Fecha de Finalizacion</p>
                            <p class="card-text">Estado</p>
                            <div class="text-right">
                                <a href="#" class="btn btn-primary">Aceptar Incidencia</a>
                                <a href="#" class="btn btn-secondary">Rechazar Incidencia</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection