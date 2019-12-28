@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Incidencia</div>
                <br><br>
                <div class="panel-body">

                @foreach($rolesusuarios as $rolusuario )
                    @if($rolusuario->user_id == (Auth::user()->id))
                        @if($rolusuario->role_id == 1)
                            <form method="POST" action="store" name="formulario">
                                {{ csrf_field() }}                                
                                <div class="form-group">
                                <label>Nombre</label>
                                <input type="text" id="nombre" name="nombre" placeholder="Ingrese el nombre de la incidencia" class="form-control" required>
                                </div>

                                <div class="form-group">
                                <label>Descripcion</label>
                                <input type="text" id="descripcion" name="descripcion" placeholder="Ingrese la descripcion de la Incidencia" class="form-control" required>
                                </div>

                                <div style="display: none">
                                <input type="text" id="user_actual" name="usuario_asigno" value="{{ Auth::user()->id }}"  required>
                                </div>

                                <div class="form-group">
                                    <label>Seleccionar Lider a Quien se Asigne Incidencia </label>
                                <select name="user_id" class="form-control">
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                </select>
                                </div>
                                
                                <div class="form-group">
                                <button id="enviar" type="submit" class="btn btn-primary guardar" value="Guardar">Guardar</button>
                                </div>
                                
                                
                            </form>




                        @elseif($rolusuario->role_id == 2)
                            <form method="POST" action="store" name="formulario">
                            {{ csrf_field() }}
                            <label>Estoy en el formulario de Encargado</label>
                            <button id="enviar" type="submit" class="btn btn-primary guardar" value="Guardar"></button>
                            </form>
                        @endif
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