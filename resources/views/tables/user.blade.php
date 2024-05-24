@extends('adminlte::page')

@section('content')

    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">

    <div class="container pt-3">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-danger text-white">
                        <h4 class="mb-0">Funcionário Numero {{$user->id}}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">Nome</label>
                                    <p class="form-control-static">{{$user->name}}</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <p class="form-control-static">{{$user->email}}</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="createdAt">Data de Criação</label>
                                    <p class="form-control-static">{{$user->created_at}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <div class="card-footer text-right">

                            @if(!$interventionsCount)
                                <a data-toggle="modal" data-target="#editUser" class="btn btn-custom">Editar</a>
                                <a type="button" class="btn btn-custom" data-toggle="modal"
                                   data-target="#deleteUser">Eliminar</a>
                            @else
                                <button data-toggle="modal" data-target="#editUser" class="btn btn-custom"
                                        disabled>Editar
                                </button>
                                <button type="button" class="btn btn-custom" disabled>Eliminar</button>
                            @endif
                            <a href="{{ url()->previous() }}" class="btn btn-secondary">Voltar Atrás</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>

    <div class="modal fade" id="editUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Atualizar Funcionário</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form autocomplete="off" method="post" action="{{route('user.update', $user->id)}}">
                        @csrf
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label"> Nome:</label>
                            <input name="name" type="text" class="form-control" value="{{$user->name}}" id="name"
                                   required>
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label"> E-mail:</label>
                            <input name="email" type="email" class="form-control" value="{{$user->email}}" id="email"
                                   required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-custom">Atualizar Funcionario</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="deleteUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Eliminar Funcionário</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form autocomplete="off" id="carForm" method="post"
                          action="{{route('user.delete', $user->id)}}">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputPassword1">Eliminar funcionário número:{{ $user->id }}</label>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-custom">Eliminar Funionário</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


