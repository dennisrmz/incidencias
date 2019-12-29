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
                            <label>Departamento</label>
                            <select id="departaments_id" name="departaments_id" class="form-control" required>
                                @foreach ($departaments as $departament)
                                <option value="{{ $departament->id }}">{{$departament->nombre}}</option>
                                @endforeach
                            </select>
                        </div>

                       <!-- <hr>
                        <h3>Lista de usuarios</h3>
                        <div class="form-group">
                            <ul class="list-unstyled">
                                @foreach($users as $user)
                                <li>
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox" name="users[]" value="{{$user->id}}">{{ $user->name }}
                                    </label>
                                </li>
                                @endforeach
                            </ul>
                        </div>-->


                        <div class="col-md-11 text-center">
                            <button type="submit" class="btn btn-success guardar">Guardar</button>
                            <a href="http://127.0.0.1:8000/equipments" class="btn btn-danger" role="button" >Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection