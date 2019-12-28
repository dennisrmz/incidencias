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
                            <input type="text" name="name" value="{{ $user->name }}" class="form-control" required>
                        </div>
                        <hr>
                        <label>Roles</label>
                        <div class="custom-control custom-checkbox">

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
                        <hr>
                        <div class="form-group">
                            <label>Departamentos</label>
                            <select id="departamentos" name="departaments_id" class="form-control" required>

                                @if($user->departaments_id == NULL)
                                <option value="" selected="true">No posee departamento</option>
                                @endif

                                @foreach ($departaments as $departament)
                                @if($user->departaments_id == $departament->id)
                                <option value="{{ $departament->id }}" selected="true">{{ $departament->nombre }}</option>
                                @else
                                <option value="{{ $departament->id }}">{{ $departament->nombre }}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label>Equipos</label>
                            <select id="equipos" name="equipments_id" class="form-control" required>
                                @if($user->equipments_id == NULL)
                                <option value="" selected="true">No posee equipo</option>
                                @endif
                                
                                
                                    @foreach ($equipments as $equipment)
                                        @if($equipment->departaments_id == $user->departaments_id)
                                            @if($user->equipments_id == $equipment->id)
                                                <option value="{{ $equipment->id }}" selected="true">{{ $equipment->nombre }}</option>
                                            @else
                                                <option value="{{ $equipment->id }}">{{ $equipment->nombre }}</option>
                                            @endif
                                        @endif
                                    @endforeach 

                            </select>
                        </div>

                        <input class="btn btn-primary" type="submit" name="enviar" value="Actualizar">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')

<script>
    $(document).ready(function() {
        $('#departamentos').on('change', function() {
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
        })
    });
</script>
@endsection