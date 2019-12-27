@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Equipos</div>
                <br><br>
                <div class="panel-body">
                    <form method="POST" action="{{ route('equipments.update', $equipment->id) }}" name="formulario">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                        <label>Nombre</label>
                        <input type="text" name="nombre" value="{{$equipment->nombre}}">
                        <br>
                        <input type="submit" name="enviar" value="Actualizar">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection