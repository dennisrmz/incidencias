<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <p style="text-align: center"><h3 style="text-align: center">Reporte de Asignaciones en Espera</h3></p>
               
                <div class="panel-body">
                    @foreach($incidenciasEnEspera as $incidencia)
                    <div class="shadow rounded card borde">
                        <h3 style="text-align: center" class="card-header">Asignada a:
                            @foreach($usuarios as $usuario)
                                @if($usuario->id == $incidencia->user_id)
                                    {{ $usuario->name }}
                                @endif
                            @endforeach
                        </h3>
                        
                        <div class="card-body">
                            <h5 class="card-title">Nombre de Incidencia: {{ $incidencia->nombre }}</h5>
                            <p class="card-text">Descripcion: {{ $incidencia->descripcion }} </p>
                            <p class="card-text">Fecha de Asignacion: {{ date('d-m-Y', strtotime($incidencia->fecha_asignacion)) }} </p>
                            <p class="card-text">Fecha de Finalizacion: {{ date('d-m-Y', strtotime($incidencia->fecha_finalizacion)) }}</p>
                            @foreach($estados as $estado)
                            @if($estado->id == $incidencia->state_id)
                            <p class="card-text">Estado: {{ $estado->nombre }}</p>
                            @endif
                            @endforeach
                        </div>
                    </div>
                    <br>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>