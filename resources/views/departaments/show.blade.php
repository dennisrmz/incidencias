@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><h1>Departamento</h1></div>
                  <br><br>
                <div class="panel-body">
                  <p><strong>Nombre:</strong> {{ $departament->nombre}}</p>
                  <p><strong>Lider:</strong> {{ $user->name }}</p>


                </div>
            </div>
        </div>
    </div>
</div>
@endsection