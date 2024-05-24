@extends('adminlte::page')

@section('content')

    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">

    <div class="container pt-3 pb-2 mb-5">
        <div class="row">
            <div class="col-md-6">
                <h1>Detalhes da Intervenção</h1>
            </div>
            <div class="col-md-6">
                <div class="float-right">
                    <a type="button" class="btn btn-secondary mr-2" href="{{ route('interventions') }}">
                        <i class="fas fa-arrow-left"></i> Voltar Atrás
                    </a>
                    <a type="button" class="btn btn-custom mr-2" data-toggle="modal" data-target="#tools">
                        <i class="fas fa-wrench"></i> Ferramentas
                    </a>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12 mt-4">
                <div class="card">
                    <div class="card-header bg-danger text-white">
                        <h4 class="mb-0">Intervenção numero {{ $intervention->id }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tbody>
                                <tr>
                                    <td>ID</td>
                                    <td>{{ $intervention->id }}</td>
                                </tr>
                                <tr>
                                    <td>Data de Criação</td>
                                    <td>{{ $intervention->created_at ? date('d/m/Y', strtotime($intervention->created_at)) : 'N/A' }}
                                        ás
                                        {{ $intervention->created_at ? date('H:i:s', strtotime($intervention->created_at)) : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td>Local</td>
                                    <td>{{ $intervention->place == 1 ? 'Loja' : 'Cliente' }}</td>
                                </tr>
                                <tr>
                                    <td>ID do Carro</td>
                                    <td>
                                        @if(($intervention->car_id))
                                            {{ ($intervention->car)->brand }} - {{ ($intervention->car)->licensePlate }}
                                        @else
                                            Avaliação realizada em loja
                                        @endif
                                    </td>
                                </tr>

                                <tr>
                                    <td>Técnico</td>
                                    <td>{{ $intervention->user_id }} - {{ ($intervention->user)->name }}</td>
                                </tr>
                                <tr>
                                    <td>Número Interno</td>
                                    <td>{{ $intervention->internalNumber }}</td>
                                </tr>
                                <tr>
                                    <td>Número de Série</td>
                                    <td>{{ $intervention->serialNumber }}</td>
                                </tr>
                                <tr>
                                    <td>Tipo de Fluido</td>
                                    <td>{{ ($intervention->fluidType)->name}}</td>
                                </tr>
                                <tr>
                                    <td>Capacidade em (kg)</td>
                                    <td>{{ $intervention->capacity }}</td>
                                </tr>
                                <tr>
                                    <td>Pressão</td>
                                    <td>{{ $intervention->pressure == 1 ? 'Sim' : 'Não' }}</td>
                                </tr>
                                <tr>
                                    <td>Nome da Fábrica</td>
                                    <td>{{ $intervention->factoryName }}</td>
                                </tr>
                                <tr>
                                    <td>Data da Fábrica</td>
                                    <td>{{ $intervention->factoryDate ? date('d/m/Y', strtotime($intervention->factoryDate)) : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td>Marcação CE</td>
                                    <td>{{ $intervention->ceMarking == 1 ? 'Sim' : 'Não' }}</td>
                                </tr>
                                <tr>
                                    <td>Localização</td>
                                    <td>{{ $intervention->localization }}</td>
                                </tr>
                                <tr>
                                    <td>Última Carga</td>
                                    <td>{{ $intervention->lastCharged ? date('d/m/Y', strtotime($intervention->lastCharged)) : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td>Último Teste Hidráulico</td>
                                    <td>{{ $intervention->lastHydraulicTest ? date('d/m/Y', strtotime($intervention->lastHydraulicTest)) : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td>Manutenção MNT</td>
                                    <td>{{ $intervention->maintenanceMNT == 1 ? 'Sim' : 'Não' }}</td>
                                </tr>
                                <tr>
                                    <td>Carga MNTAD</td>
                                    <td>{{ $intervention->chargeMNTAD == 1 ? 'Sim' : 'Não' }}</td>
                                </tr>
                                <tr>
                                    <td>Tipo</td>
                                    <td>{{ $intervention->type == 1 ? 'C' : 'S' }}</td>
                                </tr>
                                <tr>
                                    <td>Peso CO2</td>
                                    <td>{{ $intervention->co2Weight }}</td>
                                </tr>
                                <tr>
                                    <td>Prova Hidráulica</td>
                                    <td>{{ $intervention->hydraulicProve == 1 ? 'Sim' : 'Não' }}</td>
                                </tr>
                                <tr>
                                    <td>Selo de Segurança</td>
                                    <td>{{ $intervention->securityStamp == 1 ? 'Sim' : 'Não' }}</td>
                                </tr>
                                <tr>
                                    <td>O-Ring</td>
                                    <td>{{ $intervention->oRing == 1 ? 'Sim' : 'Não' }}</td>
                                </tr>
                                <tr>
                                    <td>PEG</td>
                                    <td>{{ $intervention->peg == 1 ? 'Sim' : 'Não' }}</td>
                                </tr>
                                <tr>
                                    <td>Manômetro</td>
                                    <td>{{ $intervention->manometer == 1 ? 'Sim' : 'Não' }}</td>
                                </tr>
                                <tr>
                                    <td>Difusor</td>
                                    <td>{{ $intervention->diffuser == 1 ? 'Sim' : 'Não' }}</td>
                                </tr>
                                <tr>
                                    <td>Base de plástico</td>
                                    <td>{{ $intervention->plasticBase == 1 ? 'Sim' : 'Não' }}</td>
                                </tr>
                                <tr>
                                    <td>Etiqueta</td>
                                    <td>{{ $intervention->label == 1 ? 'Sim' : 'Não' }}</td>
                                </tr>
                                <tr>
                                    <td>Sparkles</td>
                                    <td>{{ $intervention->sparkles == 1 ? 'Sim' : 'Não' }}</td>
                                </tr>
                                <tr>
                                    <td>Aprovado</td>
                                    <td>{{ $intervention->approved == 1 ? 'Sim' : 'Não' }}</td>
                                </tr>
                                <tr>
                                    <td>Novo</td>
                                    <td>{{ $intervention->new == 1 ? 'Sim' : 'Não' }}</td>
                                </tr>
                                <tr>
                                    <td>Fora de Serviço</td>
                                    <td>{{ $intervention->outofservice == 1 ? 'Sim' : 'Não' }}</td>
                                </tr>
                                <tr>
                                    <td>Motivo de Rejeição</td>
                                    <td>{{ $intervention->rejectedMotive }}</td>
                                </tr>
                                <tr>
                                    <td>ID da Fatura</td>
                                    <td>
                                        @if($intervention->invoice_id)
                                            {{ $intervention->invoice_id }}
                                        @else
                                            <a
                                                class="btn btn-info btn-icon"
                                                data-toggle="modal"
                                                data-target="#createInvoice" data-placement="top"
                                                title="Criar Fatura">
                                                <i class="far fa-file-alt"> Criar Fatura</i>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>Observações</td>
                                    <td>{{ $intervention->observations ? $intervention->observations : 'Não foram apontadas nenhumas observações relativos a esta intervenção' }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="float-right">
                <a type="button" class="btn btn-secondary mr-2" href="{{ route('interventions') }}">
                    <i class="fas fa-arrow-left"></i> Voltar Atrás
                </a>
                <a type="button" class="btn btn-custom mr-2" data-toggle="modal" data-target="#tools">
                    <i class="fas fa-wrench"></i> Ferramentas
                </a>
            </div>
        </div>
    </div>

    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>


    <!--Create Invoice-->
    <div class="modal fade" id="createInvoice" tabindex="-1"
         role="dialog"
         aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Criar
                        Fatura</h5>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form autocomplete="off" method="post"
                          action="{{route('intervention.createInvoice', $intervention->id)}}">
                        @csrf
                        <div class="form-group">
                            <label for="client"
                                   class="col-form-label">Cliente</label>
                            <input type="hidden" name="client"
                                   value="{{ $intervention->client_id }}">
                            <input type="text" class="form-control"
                                   value="{{ $intervention->client_id }}"
                                   disabled>
                        </div>
                        <div class="form-group">
                            <label for="number"
                                   class="col-form-label">Valor</label>
                            <div class="input-group-append">
                                <input name="number" id="number" type="number"
                                       class="form-control" value=""
                                       placeholder="Número da fatura"
                                       required>
                                <span class="input-group-text">€</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="discount"
                                   class="col-form-label">Desconto</label>
                            <div class="input-group-append">
                                <input name="discount" id="discount" type="number"
                                       class="form-control" value=""
                                       placeholder="Valor do desconto">
                                <span class="input-group-text">€</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="observations" class="col-form-label">Observações</label>
                            <textarea name="observations" id="observations"
                                      type="text" class="form-control" value=""
                                      placeholder="Escrever observações extra"
                                      autocomplete="false"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal">Fechar
                            </button>
                            <button type="submit" class="btn btn-custom">Criar
                                Fatura
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--Modal Tools-->
    <div class="modal fade" id="tools" tabindex="-1" role="dialog"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="interventionDetailsLabel">Ferramentas da Intervenção</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <a type="button" class="btn btn-custom mr-2"
                       href="{{ route('intervention.pdf', $intervention->id) }}">
                        <i class="fas fa-file-pdf"></i> Download PDF
                    </a>
                    @if(!$intervention->invoice_id)
                        <button href="{{ route('invoice.pdf', $intervention->invoice_id) }}"
                                class="btn btn-custom mr-2" disabled>Download Fatura
                        </button>
                        <a data-toggle="modal"
                           data-target="#editIntervention" class="btn btn-custom mr-2">Editar</a>
                        <a type="button" class="btn btn-custom" data-toggle="modal"
                           data-target="#deleteIntervention">Eliminar</a>
                    @else
                        <a href="{{ route('invoice.pdf', $intervention->invoice_id) }}"
                           class="btn btn-custom mr-2">Download Fatura</a>
                        <button type="button" class="btn btn-custom mr-2" disabled>Editar</button>
                        <button type="button" class="btn btn-custom" disabled>Eliminar</button>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <!--Delete Intervention-->
    <div class="modal fade" id="deleteIntervention" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Eliminar Intervenção</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form autocomplete="off" id="carForm" method="post"
                          action="{{route('intervention.delete', $intervention->id)}}">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputPassword1">Eliminar intervenção
                                numero:{{ $intervention->id }}</label>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-custom">Eliminar Intervenção</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--Edit Intervention-->
    <div class="modal fade" id="editIntervention" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar Intervenção</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form autocomplete="off" method="post" action="{{route('intervention.update', $intervention->id)}}">
                        @csrf

                        <div class="form-group">
                            <label for="place" class="col-form-label">Pedido Efetuado em</label>
                            <div class="row">
                                <div class="col-sm-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="place" id="place-yes"
                                               value="1" {{ $intervention->place == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="place-yes">Loja</label>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="place" id="place-no"
                                               value="0" {{ $intervention->place == 0 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="place-no">Cliente</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group" id="car-dropdown"
                             style="{{ $intervention->place == 0 ? 'display:block' : 'display:none' }}">
                            <label for="car" class="col-form-label">Escolha o veículo utilizado:</label>
                            <select class="form-control" name="car_id" id="car_id">
                                <option value="" {{ !$intervention->car_id ? 'selected' : '' }}>Escolher matricula
                                </option>
                                @foreach ($cars as $car)
                                    <option
                                        value="{{ $car->id }}" {{ $intervention->car_id == $car->id ? 'selected' : '' }}>
                                        {{ $car->brand }} - {{ $car->licensePlate }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="ceMarking" class="col-form-label">Marcação CE</label>
                            <div class="row">
                                <div class="col-sm-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="ceMarking" id="ceMarking-yes"
                                               value="1" @if ($intervention->ceMarking == 1) checked @endif>
                                        <label class="form-check-label" for="ceMarking-yes">Sim</label>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="ceMarking" id="ceMarking-no"
                                               value="0" @if ($intervention->ceMarking == 0) checked @endif>
                                        <label class="form-check-label" for="ceMarking-no">Não</label>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Número Interno</label>
                            <input name="internalNumber" id="internalNumber" type="text" class="form-control"
                                   value="{{ $intervention->internalNumber ?? '' }}" placeholder="ex: 1" required
                                   autocomplete="false">
                        </div>

                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Tipo de Agente do extintor</label>
                            <select class="form-control" name="fluid_type_id" id="fluid_type_id" required>
                                <option value="" {{ $intervention->fluid_type_id == '' ? 'selected' : '' }}>Escolher
                                    tipo de
                                    Fluido
                                </option>
                                @foreach ($fluid_types as $fluid_type)
                                    <option
                                        value="{{ $fluid_type->id }}" {{ $intervention->fluid_type_id == $fluid_type->id ? 'selected' : '' }}>
                                        {{ $fluid_type->name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>


                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label"> Serial Number</label>
                            <input name="serialNumber" id="serialNumber" type="text" class="form-control"
                                   value="{{ $intervention->serialNumber ?? '' }}" placeholder="ex: 1ABY563TR" required
                                   autocomplete="false">
                        </div>

                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Capacidade em kg</label>
                            <input name="capacity" id="capacity" type="number" class="form-control"
                                   value="{{ $intervention->capacity ?? '' }}" placeholder="ex: 15" required
                                   autocomplete="false">
                        </div>

                        <div class="form-group">
                            <label for="pressure-permanente" class="col-form-label">Pressão Permanente:</label>
                            <div class="row">
                                <div class="col-sm-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="pressure" id="pressure-yes"
                                               value="1" {{ $intervention->pressure == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="pressure-yes">Sim</label>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="pressure" id="pressure-no"
                                               value="0" {{ $intervention->pressure == 0 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="pressure-no">Não</label>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Nome do Fabricante</label>
                            <input name="factoryName" id="factoryName" type="text" class="form-control"
                                   value="{{ $intervention->factoryName ?? '' }}" placeholder="ex: Empresa X" required
                                   autocomplete="false">
                        </div>

                        <input name="factoryDate" id="factoryDate" type="date" class="form-control"
                               value="{{ $intervention->factoryDate ? date('Y-m-d', strtotime($intervention->factoryDate)) : '' }}"
                               required autocomplete="false">


                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Localização</label>
                            <input name="localization" id="localization" type="text" class="form-control"
                                   value="{{ $intervention->localization ?? '' }}"
                                   placeholder="ex:Rua X, Nº XXX, andar X"
                                   required autocomplete="false">
                        </div>

                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Ultimo Carregamento</label>
                            <input name="lastCharged" id="lastCharged" type="date" class="form-control"
                                   value="{{ $intervention->lastCharged ? date('Y-m-d', strtotime($intervention->lastCharged)) : '' }}"
                                   required autocomplete="false">
                        </div>

                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Ultimo teste Hidraulico</label>
                            <input name="lastHydraulicTest" id="lastHydraulicTest" type="date" class="form-control"
                                   value="{{ $intervention->lastHydraulicTest ? date('Y-m-d', strtotime($intervention->lastHydraulicTest)) : '' }}"
                                   required autocomplete="false">
                        </div>


                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Manutenção MNT</label>
                            <div class="row">
                                <div class="col-sm-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="maintenanceMNT"
                                               id="maintenanceMNT-yes"
                                               value="1" {{ $intervention->maintenanceMNT == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="maintenanceMNT-yes">Sim</label>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="maintenanceMNT"
                                               id="maintenanceMNT-no"
                                               value="0" {{ $intervention->maintenanceMNT == 0 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="maintenanceMNT-no">Não</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Carregamento MNT AD</label>
                            <div class="row">
                                <div class="col-sm-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="chargeMNTAD"
                                               id="chargeMNTAD-yes"
                                               value="1" {{ $intervention->chargeMNTAD == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="chargeMNTAD-yes">Sim</label>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="chargeMNTAD"
                                               id="chargeMNTAD-no"
                                               value="0" {{ $intervention->chargeMNTAD == 0 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="chargeMNTAD-no">Não</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Tipo</label>
                            <div class="row">
                                <div class="col-sm-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="type"
                                               id="type-yes"
                                               value="C" {{ $intervention->type == 'C' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="type-yes">C</label>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="type"
                                               id="type-no"
                                               value="S" {{ $intervention->type == 'S' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="type-no">S</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Peso CO2 em kg</label>
                            <input name="co2Weight" id="co2Weight" type="number"
                                   class="form-control" value="{{ $intervention->co2Weight }}" placeholder="ex:15"
                                   required autocomplete="false">
                        </div>

                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Prova Hidraulica</label>
                            <div class="row">
                                <div class="col-sm-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="hydraulicProve"
                                               id="hydraulicProve-yes"
                                               value="1" {{ $intervention->hydraulicProve == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="hydraulicProve-yes">Sim</label>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="hydraulicProve"
                                               id="hydraulicProve-no"
                                               value="0" {{ $intervention->hydraulicProve == 0 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="hydraulicProve-no">Não</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Selo de Segurança</label>
                            <div class="row">
                                <div class="col-sm-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="securityStamp"
                                               id="securityStamp-yes"
                                               value="1" {{ $intervention->securityStamp == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="securityStamp-yes">Sim</label>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="securityStamp"
                                               id="securityStamp-no"
                                               value="0" {{ $intervention->securityStamp == 0 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="securityStamp-no">Não</label>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">O-Ring</label>
                            <div class="row">
                                <div class="col-sm-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="oRing" id="oRing-yes"
                                               value="1" {{ $intervention->oRing == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="oRing-yes">Sim</label>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="oRing" id="oRing-no"
                                               value="0" {{ $intervention->oRing == 0 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="oRing-no">Não</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="peg" class="col-form-label">Cavilha</label>
                            <div class="row">
                                <div class="col-sm-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="peg" id="peg-yes"
                                               value="1" {{ $intervention->peg == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="peg-yes">Sim</label>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="peg" id="peg-no"
                                               value="0" {{ $intervention->peg == 0 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="peg-no">Não</label>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Manometro</label>
                            <div class="row">
                                <div class="col-sm-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="manometer"
                                               id="manometer-yes"
                                               value="1" {{ !$intervention->manometer == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="manometer-yes">Sim</label>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="manometer"
                                               id="manometer-no"
                                               value="0" {{ !$intervention->manometer == 0 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="manometer-no">Não</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Difusor</label>
                            <div class="row">
                                <div class="col-sm-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="diffuser"
                                               id="diffuser-yes"
                                               value="1" {{ !$intervention->diffuser == 1 ?  'checked' : '' }}>
                                        <label class="form-check-label" for="diffuser-yes">Sim</label>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="diffuser"
                                               id="diffuser-no"
                                               value="0" {{ !$intervention->diffuser == 0 ?  'checked' : '' }}>
                                        <label class="form-check-label" for="diffuser-no">Não</label>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Base Plástica</label>
                            <div class="row">
                                <div class="col-sm-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="plasticBase"
                                               id="plasticBase-yes"
                                               value="1" {{ !$intervention->plasticBase == 1 ?  'checked' : '' }}>
                                        <label class="form-check-label" for="plasticBase-yes">Sim</label>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="plasticBase"
                                               id="plasticBase-no"
                                               value="0" {{ !$intervention->plasticBase == 0 ?  'checked' : '' }}>
                                        <label class="form-check-label" for="plasticBase-no">Não</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Rótulo</label>
                            <div class="row">
                                <div class="col-sm-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="label"
                                               id="label-yes"
                                               value="1" {{ !$intervention->label == 1 ?  'checked' : '' }}>
                                        <label class="form-check-label" for="label-yes">Sim</label>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="label"
                                               id="label-no"
                                               value="0" {{ !$intervention->label == 0 ?  'checked' : '' }}>
                                        <label class="form-check-label" for="label-no">Não</label>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Sparkles</label>
                            <div class="row">
                                <div class="col-sm-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="sparkles"
                                               id="sparkles-yes"
                                               value="1" {{ !$intervention->sparkles == 1 ?  'checked' : '' }}>
                                        <label class="form-check-label" for="sparkles-yes">Sim</label>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="sparkles"
                                               id="sparkles-no"
                                               value="0" {{ !$intervention->sparkles == 0 ?  'checked' : '' }}>
                                        <label class="form-check-label" for="sparkles-no">Não</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Aprovado</label>
                            <div class="row">
                                <div class="col-sm-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="approved"
                                               id="approved-yes"
                                               value="1" {{ !$intervention->aprooved == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="approved-yes">Sim</label>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="approved"
                                               id="approved-no"
                                               value="0" {{ !$intervention->aprooved == 0 ?  'checked' : '' }}>
                                        <label class="form-check-label" for="approved-no">Não</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Fora de Serviço</label>
                            <div class="row">
                                <div class="col-sm-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="outofservice"
                                               id="outofservice-yes"
                                               value="1" {{ !$intervention->outofservice == 1 ?  'checked' : '' }}>
                                        <label class="form-check-label" for="outofservice-yes">Sim</label>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="outofservice"
                                               id="outofservice-no"
                                               value="0"{{ !$intervention->outofservice == 0 ?  'checked' : '' }}>
                                        <label class="form-check-label" for="outofservice-no">Não</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Novo</label>
                            <div class="row">
                                <div class="col-sm-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="new"
                                               id="new-yes"
                                               value="1" {{ !$intervention->new == 1 ?  'checked' : '' }}>
                                        <label class="form-check-label" for="new-yes">Sim</label>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="new"
                                               id="new-no"
                                               value="0" {{ !$intervention->new == 0 ?  'checked' : '' }}>
                                        <label class="form-check-label" for="new-no">Não</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Motivo de Rejeição</label>
                            <textarea name="rejectedMotive" id="rejectedMotive" type="text"
                                      class="form-control" placeholder="ex: Foi rejeitado porque..."
                                      required autocomplete="false">{{$intervention->rejectedMotive}}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Observações</label>
                            <textarea name="observations" id="observations" type="text"
                                      class="form-control" value="" placeholder="Escrever observações extra"
                                      autocomplete="false">{{$intervention->observations}}</textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-primary">Criar Intervenção</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--Enable/Disable car license Plate input-->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const carDropdown = document.getElementById('car-dropdown');
            const placeYes = document.getElementById('place-yes');
            const placeNo = document.getElementById('place-no');

            if (placeNo.checked) {
                carDropdown.style.display = 'block';
            } else {
                carDropdown.style.display = 'none';
            }

            placeNo.addEventListener('click', function () {
                carDropdown.style.display = 'block';
            });

            placeYes.addEventListener('click', function () {
                carDropdown.style.display = 'none';
            });
        });
    </script>

@endsection



