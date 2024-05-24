@extends('adminlte::page')

@section('title', 'Fire Hazard')

@section('content')

    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">

    <div class="row pt-3 ">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Funcionários</h3>
                </div>
                <div class="card-body">
                    <p>Nesta página pode ver, criar e editar os funcionários registados. </p>
                    <a href="{{ route('users') }}" class="btn btn-danger">Ver Funcionários</a>
                    <a class="btn btn-custom" data-toggle="modal" data-target="#createUser">Criar Funcionário</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tipos de Fluidos de Extintores</h3>
                </div>
                <div class="card-body">
                    <p>Nesta página, pode ver, criar e editar os fluidos dos extintores</p>
                    <a href="{{ route('fluids') }}" class="btn btn-danger">Ver Tipos de Fluido</a>
                    <a class="btn btn-custom" data-toggle="modal" data-target="#createFluid">Criar Tipo de Fluido</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row pt-3 ">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Veiculos Registados</h3>
                </div>
                <div class="card-body">
                    <p>Nesta página pode ver, criar e editar os veiculos registados na empresa atualmente. </p>
                    <a href="{{ route('cars') }}" class="btn btn-danger">Ver Veiculos</a>
                    <a class="btn btn-custom" data-toggle="modal" data-target="#createCar">Registar Veiculo</a>
                </div>
            </div>
        </div>
    </div>


    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>

    <div class="modal fade" id="createCar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Registar novo Veiculo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form autocomplete="off" id="carForm" method="post" action="{{route('car.create')}}">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputPassword1">Marca</label>
                            <input name="brand" type="text" class="form-control"
                                   placeholder="ex: Renault" required autocomplete="false">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Modelo</label>
                            <input name="model" type="text" class="form-control"
                                   placeholder="ex: Clio" required autocomplete="false">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Matricula</label>
                            <input name="licensePlate" id="licensePlate" type="text" class="form-control"
                                   placeholder="ex: AB.56.AB" required autocomplete="false"
                                   pattern="[A-Z0-9]{2}(\.[A-Z0-9]{2})*">
                            <small id="licensePlateError" class="text-danger d-none">Esta matricula já existe</small>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-custom">Registar Veiculo</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Car Licence-->
    <script>
        document.getElementById("licensePlate").addEventListener("input", function (e) {
            let input = e.target;
            let value = input.value;

            // Convert lowercase letters to uppercase
            input.value = value.toUpperCase();

            // Add dot (.) after entering two characters
            if (value.length === 2) {
                input.value = value + ".";
            }

            // Insert dot (.) after every two characters except at the end
            if (value.length > 2 && value.length % 3 === 2) {
                input.value = value.slice(0, value.length - 1) + "." + value.slice(value.length - 1);
            }
        });
    </script>

    <!--Create Fluid-->
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

    <!--Create User-->
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


