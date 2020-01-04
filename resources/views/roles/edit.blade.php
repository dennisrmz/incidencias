@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Rol</div>
                <br><br>
                <div class="panel-body">
                    <form method="POST" action="{{ route('roles.update', $role->id) }}" name="formulario">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="form-group">
                            <label>Nombre</label>
                            <input type="text" name="name" class="form-control" value="{{$role->name}}">
                        </div>
                        <div class="form-group">
                            <label>Slug</label>
                            <input type="text" name="slug" class="form-control" value="{{$role->slug}}">
                        </div>
                        <div class="form-group">
                            <label>Descripcion</label>
                            <input type="text" name="description" class="form-control" value="{{$role->description}}">
                        </div>
                        <hr>
                        <h3>Permiso Especial</h3>
                        <div class="form-group">
                            @if($role->special == 'all-access')
                            <label><input  type="radio" name="special" value="all-access" checked> Acceso Total</label>
                            @else
                            <label><input  type="radio" name="special" value="all-access" > Acceso Total</label>
                            @endif

                            @if($role->special == 'no-access')
                            <label><input  type="radio" name="special" value="no-access" checked> Ningun Acceso</label>
                            @else
                            <label><input  type="radio" name="special" value="no-access" > Ningun Acceso</label>
                            @endif
                            
                        </div>
                        <hr>
                        <h3>Lista de Permisos</h3>
                        <div class="form-group">
                            <ul class="list-unstyled">
                                @foreach($permissions as $permission)
                               <!--<label><h3>Permiso</h3> {{ $permission }}</label><br>
                                <label><h3>Role</h3>{{ $role->id }}</label><br>
                                <label><h3>Permiso Role</h3> {{ $permission->roles }}</label><br>
                                
                                <label><h3>Todo</h3>{{ $permission->roles->contains($role->id) }}</label><br>
                                -->
                                <!-- if para marcar checkbox seleccionado-->
                                @if($permission->roles->contains($role->id))
                                
                                <li>
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="{{$permission->id}}" checked>{{ $permission->name }}
                                        <em>({{ $permission->description ?: 'Sin Descripcion' }})</em>
                                    </label>
                                </li>
                                @else
                                <li>
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="{{$permission->id}}">{{ $permission->name }}
                                        <em>({{ $permission->description ?: 'Sin Descripcion' }})</em>
                                    </label>
                                </li>
                                @endif
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