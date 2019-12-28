@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Incidencia</div>
                <br><br>
                <div class="panel-body">
                @foreach($roles as $role )
                <label><h3>role</h3>{{ $role }}</label><br>
                <label><h3>role user</h3>{{ $role->users }} </label><br>
                <label><h3>id user</h3> {{Auth::user()->id }}</label><br>
                <label><h3>todo</h3>{{$role->users->contains(Auth::user()->id)}}</label><br>
                     @if($role->users->contains(Auth::user()->id))
                    <form method="POST" action="store" name="formulario">
                        {{ csrf_field() }}
                        <label>Estoy en el formulario de Lider</label>
                            <button id="enviar" type="submit" class="btn btn-primary guardar" value="Guardar"></button>
                        </div>
                    </form>
                    @endif
                    @if($role->users->contains(Auth::user()->id))
                    <form method="POST" action="store" name="formulario">
                        {{ csrf_field() }}
                        <label>Estoy en el formulario de Encargado</label>
                            <button id="enviar" type="submit" class="btn btn-primary guardar" value="Guardar"></button>
                        </div>
                    </form>
                    @endif
                @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')

@endsection