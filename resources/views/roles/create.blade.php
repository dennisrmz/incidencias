@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Rol</div>
                <br><br>
                <div class="panel-body">
                    <form method="POST" action="store" name="formulario">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label>Nombre</label>
                            <input type="text" name="name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Slug</label>
                            <input type="text" name="slug" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Descripcion</label>
                            <input type="text" name="description" class="form-control">
                        </div>
                        <hr>
                        <h3>Permiso Especial</h3>
                        <div class="form-group">
                            <label><input  type="radio" name="special" value="all-access"> Acceso Total</label>
                            <label><input  type="radio" name="special" value="no-access"> Ningun Acceso</label>
                        </div>
                        <hr>
                        <h3>Lista de Permisos</h3>
                        <div class="form-group">
                            <ul class="list-unstyled">
                                @foreach($permissions as $permission)
                                <li>
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="{{$permission->id}}">{{ $permission->name }}
                                        <em>({{ $permission->description ?: 'Sin Descripcion' }})</em>
                                    </label>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        <input type="submit" name="enviar" value="Guardar">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection