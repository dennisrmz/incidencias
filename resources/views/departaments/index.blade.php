@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading ">
                    <strong>Departamentos</strong>
                    @can('departaments.create')
                    <a href="{{ route('departaments.create') }}" class="btn btn-sm btn-primary float-right">Crear</a>
                    @endcan
                </div>

                <div class="panel-body">

                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Lider</th>
                                <th colspan="3">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($departaments as $departament)
                                <tr>
                                    <td>{{ $departament->nombre}}</td>
                                    <td>{{ $departament->id_lider}}</td>
                                    <td width="10px">
                                        @can('departaments.show')
                                            <a href="{{ route('departaments.show' , $departament->id) }}" class="btn btn-sm btn-secondary">
                                                Ver
                                            </a>
                                        @endcan
                                    </td>
                                    <td width="10px">
                                        @can('departaments.edit')
                                            <a href="{{ route('departaments.edit' , $departament->id) }}" class="btn btn-sm btn-default">
                                                Editar
                                            </a>
                                        @endcan
                                    </td>
                                    @can('departaments.destroy')
                                <td width="10px">
                                    {!! Form::open(['route' => ['departaments.destroy', $departament->id], 
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
                        {{ $departaments->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection