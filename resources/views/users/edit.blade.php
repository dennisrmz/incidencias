@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Usuario</div>
                <br><br>
                <div class="panel-body">
                    <form method="POST" action="{{ route('users.update', $user->id) }}" name="formulario">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <div class="form-group">
                    <input type="text" name="name" value="{{ $user->name }}" class="form-control">
                    </div>
                       
                        <br>
                        <div class="form-group">
                            <ul class="list-unstyled">
                                @foreach($roles as $role)
                                @if($user->roles->contains($role->id)) 
                                <li>
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="checkbox" name="roles[]" value="{{$role->id}}" checked>{{ $role->name }}
                                            <em>({{ $role->description ?: 'Sin Descripcion' }})</em>
                                        </label>
                                        </li>
                                @else
                                <li>
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="checkbox" name="roles[]" value="{{$role->id}}">{{ $role->name }}
                                            <em>({{ $role->description ?: 'Sin Descripcion' }})</em>
                                        </label>
                                        </li>
                                @endif
                                        
                                       
                                @endforeach

                               
                            </ul>
                        </div>
                        <input type="submit" name="enviar" value="Actualizar">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection