@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Equipo</div>
                  <br><br>
                <div class="panel-body">
                  <p><strong>Nombre:</strong> {{ $equipment->nombre}}</p>
                  <p><strong>Departamento:</strong> {{ $departament->nombre}}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection