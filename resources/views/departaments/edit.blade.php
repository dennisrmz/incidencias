@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Departamento</div>
                <br><br>
                <div class="panel-body">
                    <form method="POST" action="{{ route('departaments.update', $departament->id) }}" name="formulario">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="form-group">
                            <label>Nombre</label>
                            <input class="form-control" id="nombre" type="text" name="nombre" value="{{$departament->nombre}}">
                            <br>
                        </div>
                        <div class="form-group">
                            <label>Lider</label>
                            <select id="lideres" name="id_lider" class="form-control" required>
                                @foreach ($users as $user)
                                @if($user->id == $departament->id_lider){
                                <option value="{{ $user->id }}" selected="true">{{ $user->name }}</option>
                                }
                                @else
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                        <div style="display: none">
                            @foreach ($users as $user){
                            @if($user->id == $departament->id_lider){
                            <input type="text" name="anterior" value="{{ $user->id }}">
                            }
                            @endif
                            }
                            @endforeach
                        </div>
                        <input id="enviar" onclick="valida_envia()" class="btn btn-primary guardar" value="actualizar"></input>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')

<script type="text/javascript">
    function valida_envia() {
        //valido el nombre
        var select = document.getElementById("lideres");
        var options = document.getElementsByTagName("option");
        console.log(parseInt(select.value));

        const usuarios = {!! json_encode($users) !!}
        const liderAct = {!! json_encode($departament->toArray()) !!}
        
        console.log(liderAct.id_lider)

        // Obteniendo el valor que se puso en el campo nombre del formulario
        nombre = document.getElementById("nombre").value;
        if (nombre.length == 0 || /^\s+$/.test(nombre)) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'El campo nombre se encuentra vacio',
                timer: 3000
            })
            return false;
        } else {
            if (parseInt(select.value) == liderAct.id_lider) {
                Swal.fire({
                    icon: 'success',
                    title: 'Correcto',
                    text: 'Departamento Actualizadoo',
                    timer: 3000
                })
                document.formulario.submit();
            } else {
                for (var i = 0; i < usuarios.length; i++) {
                    if (parseInt(select.value) == usuarios[i].id) {
                        if (usuarios[i].es_lider != 1) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Correcto',
                                text: 'Departamento Actualizado',
                                timer: 3000
                            })
                            document.formulario.submit();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Este encargado ya posee un departamento asignado, seleccione otro',
                                timer: 3000
                            })
                        }

                    }
                }
            }
        }



    }
</script>

@endsection