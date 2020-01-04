@extends('layouts.app')

@section('head')
<link rel="stylesheet" href="{{ asset('css/jquery-ui.css') }}">
@endsection

@section('content')
<div class="container">
    <form action="/generarpdf/{{ Auth::user()->id }}" method="post">
    {{ csrf_field() }}
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <Label>Fecha de Inicio</Label>
                    <input type="date" id="fecha_inicio" name="fecha_inicio" placeholder="dd/MM/aaaa"  required>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <Label>Fecha de Fin</Label>
                    <input type="date" name="fecha_fin" placeholder="dd/MM/aaaa"  required>
                </div>
            </div>
            <div class="col">
                <div class="form group"><button type="submit" class="btn btn-primary">Generar PDF</button></div>
            </div>
        </div>
    </form>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            <div class="panel panel-default">
                <div class="panel-heading">Incidencias En Espera</div>
                <div class="panel-body">
                    @foreach($incidenciasEnEspera as $incidencia)
                    <div class="shadow rounded card borde">
                        <h5 class="card-header">Asignada a:
                            @foreach($usuarios as $usuario)
                            @if($usuario->id == $incidencia->user_id)
                            {{ $usuario->name }}
                            @endif
                            @endforeach
                        </h5>

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
                <div>
                    {{ $incidenciasEnEspera->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script src="{{ asset('js/jquery-ui.js') }}"></script>
<script>
    $(document).ready(function() {
        $(function() {
            $('.datepicker').datepicker({
                dateFormat: 'dd/mm/yy',
                showButtonPanel: false,
                changeMonth: false,
                changeYear: false,
                /*showOn: "button",
                buttonImage: "images/calendar.gif",
                buttonImageOnly: true,
                minDate: '+1D',
                maxDate: '+3M',*/
                inline: true
            });
        });
        $.datepicker.regional['es'] = {
            closeText: 'Cerrar',
            prevText: '<Ant',
            nextText: 'Sig>',
            currentText: 'Hoy',
            monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
            dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
            dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Juv', 'Vie', 'Sáb'],
            dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'],
            weekHeader: 'Sm',
            dateFormat: 'dd/mm/yy',
            firstDay: 1,
            isRTL: false,
            showMonthAfterYear: false,
            yearSuffix: ''
        };
        $.datepicker.setDefaults($.datepicker.regional['es']);
    });
</script>
@endsection