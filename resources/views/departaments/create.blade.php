@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Departamento</div>
                <br><br>
                <div class="panel-body">
                    <form method="POST" action="store" name="formulario">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label>Nombre</label>
                            <input type="text" name="nombre" placeholder="Ingrese El Nombre del Departamento" class="form-control">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success guardar">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection