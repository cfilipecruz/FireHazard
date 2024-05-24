@extends('adminlte::page')

@section('content')

    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">


    <div class="container pt-4">
        <a class="btn btn-custom btn-block mb-3" data-toggle="modal"
           data-target="#createFluid">Criar Novo Tipo de Fluido </a>
        <h1>Tipos de Fluidos de Extintores</h1>
        <table class="table table-bordered">
            <thead>
            <tr class="text-center">
                <th>ID</th>
                <th>Nome</th>
                <th>Data de Criação</th>
                <th>Ver Mais</th>
            </tr>
            </thead>
            <tbody>
            <!-- Loop through the fluids and generate a row for each one -->
            @foreach ($fluids as $fluid)
                <tr class="text-center">
                    <td>{{ $fluid->id }}</td>
                    <td>{{ $fluid->name }}</td>
                    <td>{{ date('d/m/Y', strtotime($fluid->created_at)) }}</td>
                    <td>
                        <div class="d-flex justify-content-around">
                            @if(!$fluid->interventions || count($fluid->interventions) === 0)
                                <a href="{{ route('fluid.update', $fluid->id) }}"
                                   class="btn btn-outline-success btn-icon animated-hover"
                                   data-placement="top" title="Editar Intervenção"
                                   data-toggle="modal"
                                   data-target="#editFluid-{{ $fluid->id }}">
                                    <i class="far fa-edit"></i>
                                </a>
                                <a href="{{ route('fluid.delete', $fluid->id) }}"
                                   class="btn btn-outline-warning btn-icon animated-hover"
                                   data-placement="top" title="Eliminar Intervenção"
                                   data-toggle="modal"
                                   data-target="#deleteFluid-{{$fluid->id}}">
                                    <i class="far fa-trash-alt"></i>
                                </a>

                                <!--Edit Fluid-->
                                <div class="modal fade" id="editFluid-{{$fluid->id}}" tabindex="-1" role="dialog"
                                     aria-labelledby="exampleModalLabel"
                                     aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Atualizar Tipo de
                                                    Fluido</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form autocomplete="off" method="post"
                                                      action="{{route('fluid.update', $fluid->id)}}">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label for="recipient-name" class="col-form-label">
                                                            Nome:</label>
                                                        <input name="name" type="text" class="form-control"
                                                               value="{{$fluid->name}}" id="name"
                                                               required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="recipient-name" class="col-form-label">
                                                            Descrição:</label>
                                                        <input name="description" type="text" class="form-control"
                                                               value="{{$fluid->description}}"
                                                               id="description"
                                                               required>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Fechar
                                                        </button>
                                                        <button type="submit" class="btn btn-custom">Atualizar Tipo de
                                                            Fluido
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!--Delete Fluid-->
                                <div class="modal fade" id="deleteFluid-{{$fluid->id}}" tabindex="-1" role="dialog"
                                     aria-labelledby="exampleModalLabel"
                                     aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Eliminar Tipo de
                                                    Fluido</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form autocomplete="off" id="carForm" method="post"
                                                      action="{{route('fluid.delete', $fluid->id)}}">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label for="exampleInputPassword1">Eliminar Tipo de Fluido
                                                            numero:{{ $fluid->id }}</label>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Fechar
                                                        </button>
                                                        <button type="submit" class="btn btn-custom">Eliminar Tipo de
                                                            Fluido
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <a style="pointer-events: none;"
                                   href="{{ route('fluid.update', $fluid->id) }}"
                                   class="btn btn-outline-secondary btn-icon animated-hover"
                                   data-placement="top" title="Editar Intervenção">
                                    <i class="far fa-edit"></i>
                                </a>
                                <a style="pointer-events: none;"
                                   href="{{ route('fluid.delete', $fluid->id) }}"
                                   class="btn btn-outline-secondary btn-icon animated-hover"
                                   data-placement="top" title="Eliminar Intervenção">
                                    <i class="far fa-trash-alt"></i>
                                </a>
                            @endif
                            <a href="{{ route('fluid.view', $fluid->id) }}"
                               class="btn btn-outline-info btn-icon animated-hover"
                               data-placement="top" title="Ver Mais Detalhes">
                                <i class="far fa-eye"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    @if ($fluids->hasPages())
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                {{-- Previous Page Link --}}
                @if ($cars->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link">Anterior</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $cars->previousPageUrl() }}"
                           rel="prev">Anterior</a>
                    </li>
                @endif
                {{-- Pagination Elements --}}
                @foreach (range(1, $cars->lastPage()) as $page)
                    @if ($page == $cars->currentPage())
                        <li class="page-item active">
                            <span class="page-link">{{ $page }}</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $cars->url($page) }}">{{ $page }}</a>
                        </li>
                    @endif
                @endforeach
                {{-- Next Page Link --}}
                @if ($cars->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $cars->nextPageUrl() }}" rel="next">Próximo</a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <span class="page-link">Próximo</span>
                    </li>
                @endif
            </ul>
        </nav>
    @endif
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>

    <div class="modal fade" id="createFluid" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Criar novo Tipo de Fluido</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form autocomplete="off" method="post" action="{{route('fluid.create')}}">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputPassword1">Nome</label>
                            <input name="name" type="text" class="form-control"
                                   id="password"
                                   placeholder="Nome do Fluido" required autocomplete="false">
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label"> Descrição</label>
                            <textarea name="description" type="text" class="form-control" value="" id="description"
                                      placeholder="Descreva sucintamente a ação do tipo de fluido interno"
                                      required></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-custom">Criar Fluido</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

























