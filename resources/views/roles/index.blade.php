@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading ">
                    <strong>Roles</strong>
                    @can('roles.create')
                    <a href="{{ route('roles.create') }}" class="btn btn-sm btn-primary float-right">Crear</a>
                    @endcan
                </div>

                <div class="panel-body">

                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Role</th>
                                <th colspan="3">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($roles as $role)
                                <tr>
                                    <td>{{ $role->name}}</td>
                                    <td width="10px">
                                        @can('roles.show')
                                            <a href="{{ route('roles.show' , $role->id) }}" class="btn btn-sm btn-secondary">
                                                Ver
                                            </a>
                                        @endcan
                                    </td>
                                    <td width="10px">
                                        @can('roles.edit')
                                            <a href="{{ route('roles.edit' , $role->id) }}" class="btn btn-sm btn-default">
                                                Editar
                                            </a>
                                        @endcan
                                    </td>
                                    @can('roles.destroy')
                                <td width="10px">
                                    {!! Form::open(['route' => ['roles.destroy', $role->id], 
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
                        {{ $roles->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection