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
                            <input type="text" id="nombre" name="nombre" placeholder="Ingrese El Nombre del Departamento" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Lider</label>
                            <select id="lideres" name="users_id" class="form-control"  required>
                                @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <input id="enviar" onclick="valida_envia()" class="btn btn-primary guardar" value="Guardar"></input>
                        </div>
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

        
            for (var i = 0; i < usuarios.length; i++) {
                if (parseInt(select.value) == usuarios[i].id ) {
                    if(usuarios[i].es_lider != 1){
                    Swal.fire({
                        icon: 'success',
                        title: 'Correcto',
                        text: 'Departamento Actualizado',
                        timer: 3000
                    })
                    document.formulario.submit();
                    }else{
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
</script>

@endsection