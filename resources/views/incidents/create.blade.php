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
                    <!--*********************** Formulario para Encargado************************************** -->
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



                    <!--*********************** Formulario para lider ************************************** -->

                    @elseif($rolusuario->role_id == 2)
                    <form method="POST" action="storeLider" name="formulario">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label>Asignar Incidencia a</label>
                            <select name="form_seleccion" id="form_seleccion" class="form-control" required>
                                <option value="" disabled selected="true">Seleccione una de las opciones</option>
                                <option value="1">Personal Individual</option>
                                <option value="2">Equipo</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Departamentos</label>
                            <select id="departamentos" name="departamentslider_id" class="form-control" required>

                                <option value="" selected="true">No posee departamento</option>

                                @foreach ($departaments as $departament)
                                @if(Auth::user()->departaments_id == $departament->id)
                                <option value="{{ $departament->id }}" selected="true">{{ $departament->nombre }}</option>
                                @else
                                <option value="{{ $departament->id }}">{{ $departament->nombre }}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>

                        <br>

                        <div class="form-group" id="especificaciones-formulario"></div>

                        <br>

                        <div class="form-group">
                            <label>Nombre</label>
                            <input type="text" id="nombre" name="nombreIncidencia" placeholder="Ingrese el nombre de la incidencia" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Descripcion</label>
                            <input type="text" id="descripcion" name="descripcionIncidencia" placeholder="Ingrese la descripcion de la Incidencia" class="form-control" required>
                        </div>

                        <div style="display: none">
                            <input type="text" id="user_actual" name="usuario_asignoIncidencia" value="{{ Auth::user()->id }}" required>
                        </div>


                        <div class="form-group">
                            <Label>Fecha de Finalizacion</Label>
                            <input name="fecha_finalizacionIncidencia" placeholder="dd/MM/aaaa" id="datepicker" class="datepicker" required>
                        </div>

                        <div class="form-group">
                            <button id="enviar" type="submit" class="btn btn-primary guardar" value="Guardar">Guardar</button>
                        </div>

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

<script>
    // ************************ Funcion para mostrar formulario de equipo o persona individual ***************************//
    $(function() {
        $('#form_seleccion').on('change', function() {
            var formulario = $(this).val()
            var codigo
            console.log(formulario);
            var Parent = document.getElementById('especificaciones-formulario');
            while (Parent.hasChildNodes()) {
                Parent.removeChild(Parent.firstChild);
            }
            if (formulario == "2") {
                codigo = `<label class="datos-cliente">Equipo</label> 
            <select id="equipos" name="equipments_idIncidencia" class="form-control">
            </select>
            <br>
            
            <table id="users" class="table table-striped table-hover">
            <thead>
            <tr>
              <th>Nombre</th>
            </tr>
            </thead>
            <tbody>
                
            </tbody>
            </table>
            
            `
            } else if (formulario == "1") {
                codigo = `<label class="datos-cliente">Personal de Departamento</label> 
                        <select id="usuarios" name="user_idIncidencia" class="form-control">
                        </select>
                        <br>
                        `
            }
            $('#especificaciones-formulario').append(codigo)
        })
    })

    // *************** Funcion para mostrar los equipo del departamento que esta cargado por defecto al elegir equipos ***************************//
    $(document).ready(function() {

        var seleccion = $('#departamentos').val();
        $('#form_seleccion').on('change', function() {
            var tipoSeleccion = $(this).val();
            if (tipoSeleccion == '2') {
                if ($.trim(seleccion) != '') {
                    console.log('entre' + seleccion);
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: 'POST',
                        url: 'http://localhost:8000/equipmentsid',
                        data: {
                            "departamento_id": seleccion
                        },
                        success: function(equipments) {

                            console.log('en peticion');
                            $('#equipos').empty();
                            $('#equipos').append("<option value=''>Seleccione un equipo</option>");
                            $.each(equipments, function(index, value) {
                                $('#equipos').append("<option value='" + index + "'>" + value + "</option>")
                            })
                        }

                    });
                }
            } else if (tipoSeleccion == '1') {
                if ($.trim(seleccion) != '') {
                    console.log('entre' + seleccion);
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: 'POST',
                        url: '/usersdepartamentid',
                        data: {
                            "seleccion": seleccion
                        },
                        success: function(users) {

                            console.log(users);
                            $('#usuarios').empty();
                            $('#usuarios').append("<option value=''>Seleccione un usuario</option>");
                            $.each(users, function(index, value) {
                                if (value[1] == 0) {
                                    $('#usuarios').append(`<option value="${index}"> ${value[0]}</option>`)
                                }

                            })
                        }

                    });
                }
            }

        })


        // *************** Funcion para mostrar equipos del departamento seleccionado al cambiar valor del select ***************************//
        $('#departamentos').on('change', function() {
            var form_seleccionado = $('#form_seleccion').val();
            console.log(form_seleccionado);
            if (form_seleccionado == '2') {
                var departamento_id = $(this).val();

                if ($.trim(departamento_id) != '') {
                    console.log('entre' + departamento_id);
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: 'POST',
                        url: 'http://localhost:8000/equipmentsid',
                        data: {
                            "departamento_id": departamento_id
                        },
                        success: function(equipments) {

                            console.log('en peticion');
                            $('#equipos').empty();
                            $('#equipos').append("<option value=''>Seleccione un equipo</option>");
                            $.each(equipments, function(index, value) {
                                $('#equipos').append("<option value='" + index + "'>" + value + "</option>")
                            })
                        }

                    });
                }
            }else if (form_seleccionado == '1') {
                var seleccion = $(this).val();
                if ($.trim(seleccion) != '') {
                    console.log('entre' + seleccion);
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: 'POST',
                        url: '/usersdepartamentid',
                        data: {
                            "seleccion": seleccion
                        },
                        success: function(users) {

                            console.log(users);
                            $('#usuarios').empty();
                            $('#usuarios').append("<option value=''>Seleccione un usuario</option>");
                            $.each(users, function(index, value) {
                                if (value[1] == 0) {
                                    $('#usuarios').append(`<option value="${index}"> ${value[0]}</option>`)
                                }

                            })
                        }

                    });
                }
            }

        })

        // *************** funcion para cargar usuarios de equipo  ***************************//

        $('div#especificaciones-formulario').on('change', "select#equipos", function() {
            var equipo_id = $(this).val();
            if ($.trim(equipo_id) != '') {
                console.log('entre' + equipo_id);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'POST',
                    url: 'http://localhost:8000/usersid',
                    data: {
                        "equipo_id": equipo_id
                    },
                    success: function(user) {
                        $("#users tr").remove();
                        $('thead').append(`<tr> 
                                <th>Nombres</th>
                                </tr>
                              `)
                        $.each(user, function(index, value) {
                            $('tbody').append(`<tr> 
                                <td>${value}</td>
                                </tr>
                              `)
                        })
                    }

                });
            }
        })

    });
</script>

@endsection