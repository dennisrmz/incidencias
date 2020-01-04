@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Equipos</div>
                <br><br>
                <div class="panel-body">
                    <form method="POST" action="store" name="formulario">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label>Nombre</label>
                            <input type="text" name="nombre" placeholder="Ingrese el nombre del equipo" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>departamentos</label>
                            <select id="departamentos" name="departaments_id" class="form-control">
                                <option value="" disabled selected="true">Seleccione el departamento al cual pertenecera el equipo</option>
                                @foreach ($departaments as $departament)
                                    <option value="{{ $departament->id }}">{{ $departament->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection