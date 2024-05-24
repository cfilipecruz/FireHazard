@extends('adminlte::page')

@section('content')

    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">

    <div class="container pt-4">
        <a class="btn btn-block mb-3 btn-custom" data-toggle="modal" data-target="#createUser">Criar novo
            Funcionário</a>

        <h1>Funcionários</h1>
        <table class="table table-bordered">
            <thead>
            <tr class="text-center">
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Ver Mais</th>
            </tr>
            </thead>
            <tbody>
            <!-- Loop through the users and generate a row for each one -->
            @foreach ($users as $user)
                <tr class="text-center">
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <div class="d-flex justify-content-around">
                            @if(!$user->interventions || count($user->interventions) === 0)
                                <a href="{{ route('user.update', $user->id) }}"
                                   class="btn btn-outline-success btn-icon animated-hover"
                                   data-placement="top" title="Editar Funcionário" data-toggle="modal"
                                   data-target="#editUser-{{$user->id}}">
                                    <i class="far fa-edit"></i>
                                </a>
                                <a href="{{ route('user.delete', $user->id) }}"
                                   class="btn btn-outline-warning btn-icon animated-hover"
                                   data-placement="top" title="Eliminar Funcionário" data-toggle="modal"
                                   data-target="#deleteUser-{{$user->id}}">
                                    <i class="far fa-trash-alt"></i>
                                </a>

                                <!--Edit User Modal-->
                                <div class="modal fade" id="editUser-{{$user->id}}" tabindex="-1" role="dialog"
                                     aria-labelledby="exampleModalLabel"
                                     aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Atualizar
                                                    Funcionário</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form autocomplete="off" method="post"
                                                      action="{{route('user.update', $user->id)}}">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label for="recipient-name" class="col-form-label">
                                                            Nome:</label>
                                                        <input name="name" type="text" class="form-control"
                                                               value="{{$user->name}}" id="name"
                                                               required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="recipient-name" class="col-form-label">
                                                            E-mail:</label>
                                                        <input name="email" type="email" class="form-control"
                                                               value="{{$user->email}}" id="email"
                                                               required>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Fechar
                                                        </button>
                                                        <button type="submit" class="btn btn-custom">Atualizar
                                                            Funcionario
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--Delete User Modal-->
                                <div class="modal fade" id="deleteUser-{{$user->id}}" tabindex="-1" role="dialog"
                                     aria-labelledby="exampleModalLabel"
                                     aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Eliminar Funcionário</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form autocomplete="off" id="carForm" method="post"
                                                      action="{{route('user.delete', $user->id)}}">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label for="exampleInputPassword1">Eliminar funcionário
                                                            número:{{ $user->id }}</label>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Fechar
                                                        </button>
                                                        <button type="submit" class="btn btn-custom">Eliminar
                                                            Funionário
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <a style="pointer-events: none;"
                                   href="{{ route('user.update', $user->id) }}"
                                   class="btn btn-outline-secondary btn-icon animated-hover"
                                   data-placement="top" title="Editar Funcionáro">
                                    <i class="far fa-edit"></i>
                                </a>
                                <a style="pointer-events: none;"
                                   href="{{ route('user.delete', $user->id) }}"
                                   class="btn btn-outline-secondary btn-icon animated-hover"
                                   data-placement="top" title="Eliminar Funcionário">
                                    <i class="far fa-trash-alt"></i>
                                </a>
                            @endif
                            <a href="{{ route('user.view', $user->id) }}"
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
    @if ($users->hasPages())
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                {{-- Previous Page Link --}}
                @if ($users->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link">Anterior</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $users->previousPageUrl() }}"
                           rel="prev">Anterior</a>
                    </li>
                @endif
                {{-- Pagination Elements --}}
                @foreach (range(1, $users->lastPage()) as $page)
                    @if ($page == $users->currentPage())
                        <li class="page-item active">
                            <span class="page-link">{{ $page }}</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $users->url($page) }}">{{ $page }}</a>
                        </li>
                    @endif
                @endforeach
                {{-- Next Page Link --}}
                @if ($users->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $users->nextPageUrl() }}" rel="next">Próximo</a>
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

    <div class="modal fade" id="createUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Criar novo Funcionário</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form autocomplete="off" method="post" action="{{route('user.create')}}">
                        @csrf
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label"> Nome:</label>
                            <input name="name" type="text" class="form-control" value="" id="nomecompleto"
                                   required>
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label"> E-mail:</label>
                            <input name="email" type="email" class="form-control" value="" id="email"
                                   required>
                            <div id="email-error"></div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Password</label>
                            <input name="password" type="password" class="form-control"
                                   id="password"
                                   placeholder="Password" minlength="8" required autocomplete="false">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-custom">Criar Funcionario</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection



























