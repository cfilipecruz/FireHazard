@extends('adminlte::page')

@section('content')

    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">

    <div class="container-fluid pt-3">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-danger text-white">
                        <h4 class="mb-0">Tipo de Fluido Numero {{$fluid->id}}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fluid-name">Nome</label>
                                    <p class="form-control-static">{{$fluid->name}}</p>
                                </div>
                                <div class="form-group">
                                    <label for="fluid-description">Descrição</label>
                                    <p class="form-control-static">{{$fluid->description}}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fluid-created-at">Data de Criação</label>
                                    <p class="form-control-static">{{$fluid->created_at->format('d/m/Y H:i:s')}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <div class="card-footer text-right">

                            @if(!$interventionsCount)
                                <a data-toggle="modal" data-target="#editFluid" class="btn btn-custom">Editar</a>
                                <a type="button" class="btn btn-custom" data-toggle="modal"
                                   data-target="#deleteFluid">Eliminar</a>
                            @else
                                <button data-toggle="modal" data-target="#editFluid" class="btn btn-custom"
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

    <!--Edit Fluid-->
    <div class="modal fade" id="editFluid" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Atualizar Tipo de Fluido</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form autocomplete="off" method="post" action="{{route('fluid.update', $fluid->id)}}">
                        @csrf
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label"> Nome:</label>
                            <input name="name" type="text" class="form-control" value="{{$fluid->name}}" id="name"
                                   required>
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label"> Descrição:</label>
                            <input name="description" type="text" class="form-control" value="{{$fluid->description}}"
                                   id="description"
                                   required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-custom">Atualizar Tipo de Fluido</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--Delete Fluid-->
    <div class="modal fade" id="deleteFluid" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Eliminar Tipo de Fluido</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form autocomplete="off" id="carForm" method="post"
                          action="{{route('fluid.delete', $fluid->id)}}">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputPassword1">Eliminar Tipo de Fluido numero:{{ $fluid->id }}</label>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-custom">Eliminar Tipo de Fluido</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection


