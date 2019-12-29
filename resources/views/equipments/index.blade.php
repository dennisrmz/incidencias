@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading ">
                    <strong>Equipos</strong>
                    @can('equipments.create')
                    <a href="{{ route('equipments.create') }}" class="btn btn-sm btn-primary float-right">Crear</a>
                    @endcan
                </div>

                <div class="panel-body">

                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Departamento</th>
                                <th colspan="3">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($equipments as $equipment)
                                <tr>
                                    <td>{{ $equipment->nombre}}</td>
                                    <td>{{ $equipment->departaments_id}}</td>
                                    <td width="10px">
                                        @can('equipments.show')
                                            <a href="{{ route('equipments.show' , $equipment->id) }}" class="btn btn-sm btn-secondary">
                                                Ver
                                            </a>
                                        @endcan
                                    </td>

                                    <td width="10px">
                                        @can('equipments.edit')
                                            <a href="{{ route('equipments.edit' , $equipment->id) }}" class="btn btn-sm btn-default">
                                                Editar
                                            </a>
                                        @endcan
                                    </td>

                                    @can('equipments.destroy')
                                <td width="10px">
                                    {!! Form::open(['route' => ['equipments.destroy', $equipment->id], 
                                    'method' => 'DELETE']) !!}
                                        <button class="btn btn-sm btn-danger">
                                            Eliminar
                                        </button>
                                    {!! Form::close() !!}
                                </td>
                                @endcan
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div>
                        {{ $equipments->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection