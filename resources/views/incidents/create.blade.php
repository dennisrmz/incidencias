@extends('layouts.app')

@section('head')
    <link rel="stylesheet" href="{{ asset('css/jquery-ui.css') }}">
@endsection

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
                            <input type="text" id="user_actual" name="usuario_asigno" value="{{ Auth::user()->id }}" required>
                        </div>

                        <div class="form-group">
                            <label>Seleccionar Lider a Quien se Asigne Incidencia </label>
                            <select name="user_id[]" class="form-control">
                                @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <Label>Fecha de Finalizacion</Label>
                            <input name="fecha_finalizacion" placeholder="dd/MM/aaaa" id="datepicker" class="datepicker" required>
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