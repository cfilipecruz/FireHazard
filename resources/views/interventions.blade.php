@extends('adminlte::page')

@section('title', 'Fire Hazard')

@section('content')
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">

    <div class="container pt-4">
        <div class="d-flex mb-3">
            <a class="btn btn-custom mr-3" data-toggle="modal" data-target="#newIntervention">
                Criar Nova Intervenção
            </a>
            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#filterModal">
                Filtros
            </button>
        </div>

        <h1>Histórico de Intervenções</h1>
        @if(count($interventions) <= 0)
            <div class="text-center my-5">
                <div class="filter-info">
                    <p>Não foram encontrados nenhuns resultados para:</p>
                    <ul class="list-unstyled">
                        @if ($filters['user'])
                            <li class="mb-2">
                                <strong>Técnico:</strong> {{ $users->find($filters['user'])->name }}</li>
                        @endif
                        @if ($filters['client_id'])
                            <li class="mb-2">
                                <strong>Cliente:</strong> {{ collect($clients)->where('id', $filters['client_id'])->pluck('name')->first() }}
                            </li>
                        @endif
                        @if ($filters['id_invoice'])
                            <li class="mb-2"><strong>ID da Fatura:</strong> {{ $filters['id_invoice'] }}</li>
                        @endif
                        @if (isset($filters['approved']))
                            <li class="mb-2">
                                <strong>Aprovado:</strong> {{ $filters['approved'] == 1 ? 'Sim' : 'Não' }}</li>
                        @endif
                        @if ($filters['start_date'])
                            <li class="mb-2"><strong>Intervalo de Datas:</strong> {{ $filters['start_date'] }}
                                até {{ $filters['end_date'] }}</li>
                        @endif
                    </ul>
                </div>
            </div>
        @else
            <div class="table-responsive " id="dynamic-content">
                <table class="table table-bordered table-hover">
                    <thead>
                    <tr class="text-center">
                        <th style="text-align: center; vertical-align: middle;">ID</th>
                        <th style="text-align: center; vertical-align: middle;">Técnico</th>
                        <th style="text-align: center; vertical-align: middle;">ID da Fatura</th>
                        <th style="text-align: center; vertical-align: middle;">Nome Cliente</th>
                        <th style="text-align: center; vertical-align: middle;">Nome de Fábrica</th>
                        <th style="text-align: center; vertical-align: middle;">Número de Série</th>
                        <th style="text-align: center; vertical-align: middle;">Feito em:</th>
                        <th style="text-align: center; vertical-align: middle;">Aprovado</th>
                        <th style="text-align: center; vertical-align: middle;">Novo</th>
                        <th style="text-align: center; vertical-align: middle;">Data</th>
                        <th style="text-align: center; vertical-align: middle;">Opções</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($interventions as $intervention)
                        <tr>
                            <td class="text-center">{{ $intervention->id }}</td>
                            <td class="text-center">{{ Str::limit(($intervention->user)->name, 10, '...') }}</td>
                            <td class="text-center">
                                @if($intervention->invoice_id)
                                    {{ $intervention->invoice_id }}
                                    <a href="" data-toggle="modal"
                                       data-target="#sendInvoice-{{ $intervention->id }}">
                                        <i class="fas fa-paper-plane text-info" title="Enviar fatura por e-mail"></i>
                                    </a>
                                @else
                                    Sem Fatura
                                @endif
                            </td>
                            <td class="text-center"> @foreach ($clients as $client)
                                    @if ($client['id'] === $intervention['client_id'])
                                        {{ Str::limit($client['name'], 12, '...') }}
                                    @endif
                                @endforeach</td>
                            <td class="text-center">{{ $intervention->factoryName }}</td>
                            <td class="text-center">{{ Str::limit($intervention->serialNumber, 10, '...') }}</td>

                            <td class="text-center">
                                @if ($intervention->place == 1)
                                    Loja
                                @else
                                    Cliente: {{ ($intervention->car)->licensePlate }}
                                @endif
                            </td>
                            <td class="text-center">{{ $intervention->approved == 1 ? 'Sim' : 'Não'}}</td>
                            <td class="text-center">{{ $intervention->new == 1 ? 'Sim' : 'Não'}}</td>
                            <td class="text-center">{{ $intervention->created_at ? date('d/m/Y', strtotime($intervention->created_at)) : 'N/A'  }}</td>
                            <td class="">
                                <div class="d-flex justify-content-around">
                                    <a href="{{ route('intervention.pdf', $intervention->id) }}"
                                       class="btn btn-outline-primary animated-hover "
                                       data-placement="top" title="Gerar Relatório PDF">
                                        <i class="far fa-file-pdf"></i>
                                    </a>
                                    @if(!$intervention->invoice_id)
                                        <a
                                            class="btn btn-outline-danger btn-icon animated-hover" data-toggle="modal"
                                            data-target="#createInvoice-{{$intervention->id}}" data-placement="top"
                                            title="Criar Fatura">
                                            <i class="far fa-file-alt"></i>
                                        </a>
                                        <a
                                            class="btn btn-outline-success btn-icon animated-hover"
                                            data-toggle="modal"
                                            data-target="#updateIntervention-{{$intervention->id}}"
                                            data-placement="top" title="Editar Intervenção">
                                            <i class="far fa-edit"></i>
                                        </a>
                                        <a
                                            class="btn btn-outline-warning btn-icon animated-hover"
                                            data-toggle="modal"
                                            data-target="#deleteIntervention-{{$intervention->id}}"
                                            data-placement="top" title="Eliminar Intervenção">
                                            <i class="far fa-trash-alt"></i>
                                        </a>

                                        <!--Create Invoice-->
                                        <div class="modal fade" id="createInvoice-{{$intervention->id}}" tabindex="-1"
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

                                        <!--Delete Intervention-->
                                        <div class="modal fade" id="deleteIntervention-{{$intervention->id}}"
                                             tabindex="-1" role="dialog"
                                             aria-labelledby="exampleModalLabel"
                                             aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Eliminar
                                                            Intervenção</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
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
                                                                <button type="button" class="btn btn-secondary"
                                                                        data-dismiss="modal">Fechar
                                                                </button>
                                                                <button type="submit" class="btn btn-custom">Eliminar
                                                                    Intervenção
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!--Edit Intervention-->
                                        <div class="modal fade" id="updateIntervention-{{ $intervention->id }}"
                                             tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                             aria-hidden="true">
                                            <div class="modal-dialog modal-xl" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Editar
                                                            Intervenção numero {{ $intervention->id }}</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form autocomplete="off" method="post"
                                                              action="{{route('intervention.update', $intervention->id)}}">
                                                            @csrf
                                                            <div class="row">
                                                                <div class="col-lg-6">
                                                                    <!-- Left Column -->
                                                                    <div class="form-group">
                                                                        <label for="place"
                                                                               class="col-form-label">Pedido
                                                                            Efetuado em</label>
                                                                        <div class="row">
                                                                            <div class="col-sm-2">
                                                                                <div class="form-check">
                                                                                    <input class="form-check-input"
                                                                                           type="radio"
                                                                                           name="place"
                                                                                           id="place_yes_Edit_{{ $intervention->id }}"
                                                                                           value="1"
                                                                                           {{ $intervention->place == 1 ? 'checked' : '' }} onclick="handlePlaceChange({{ $intervention->id }})">
                                                                                    <label class=" form-check-label"
                                                                                           for="place-yes">Loja</label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-2">
                                                                                <div class="form-check">
                                                                                    <input class="form-check-input"
                                                                                           type="radio"
                                                                                           name="place"
                                                                                           id="place_no_Edit_{{ $intervention->id }}"
                                                                                           onclick="handlePlaceChange({{ $intervention->id }})"
                                                                                           value="
                                                                                   0" {{ $intervention->place == 0 ? 'checked' : '' }}
                                                                                    >
                                                                                    <label class="form-check-label"
                                                                                           for="place-no">Cliente</label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group"
                                                                         id="car_dropdown_Edit_{{ $intervention->id }}"
                                                                         style="{{ $intervention->place == 0 ? 'display:block' : 'display:none' }}">
                                                                        <label for="car" class="col-form-label">Escolha
                                                                            o
                                                                            veículo utilizado:</label>
                                                                        <select class="form-control" name="car_id_Edit"
                                                                                id="car_id_Edit_{{ $intervention->id }}">
                                                                            <option
                                                                                value="" {{ $intervention->car_id ? 'selected' : '' }}>
                                                                                Escolher matricula
                                                                            </option>
                                                                            @foreach ($cars as $car)
                                                                                <option
                                                                                    value="{{ $car->id }}" {{ $intervention->car_id == $car->id ? 'selected' : '' }}>
                                                                                    {{ $car->brand }}
                                                                                    - {{ $car->licensePlate }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="ceMarking" class="col-form-label">Marcação
                                                                            CE</label>
                                                                        <div class="row">
                                                                            <div class="col-sm-2">
                                                                                <div class="form-check">
                                                                                    <input class="form-check-input"
                                                                                           type="radio"
                                                                                           name="ceMarking"
                                                                                           id="ceMarking-yes"
                                                                                           value="1"
                                                                                           @if ($intervention->ceMarking == 1) checked @endif>
                                                                                    <label class="form-check-label"
                                                                                           for="ceMarking-yes">Sim</label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-2">
                                                                                <div class="form-check">
                                                                                    <input class="form-check-input"
                                                                                           type="radio"
                                                                                           name="ceMarking"
                                                                                           id="ceMarking-no"
                                                                                           value="0"
                                                                                           @if ($intervention->ceMarking == 0) checked @endif>
                                                                                    <label class="form-check-label"
                                                                                           for="ceMarking-no">Não</label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="recipient-name"
                                                                               class="col-form-label">Número
                                                                            Interno</label>
                                                                        <input name="internalNumber" id="internalNumber"
                                                                               type="text" class="form-control"
                                                                               value="{{ $intervention->internalNumber ?? '' }}"
                                                                               placeholder="ex: 1" required
                                                                               autocomplete="false">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="recipient-name"
                                                                               class="col-form-label">Tipo
                                                                            de Agente do extintor</label>
                                                                        <select class="form-control"
                                                                                name="fluid_type_id"
                                                                                id="fluid_type_id" required>
                                                                            <option
                                                                                value="" {{ $intervention->fluid_type_id == '' ? 'selected' : '' }}>
                                                                                Escolher tipo de
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
                                                                        <label for="recipient-name"
                                                                               class="col-form-label">
                                                                            Numero de Série</label>
                                                                        <input name="serialNumber" id="serialNumber"
                                                                               type="text"
                                                                               class="form-control"
                                                                               value="{{ $intervention->serialNumber ?? '' }}"
                                                                               placeholder="ex: 1ABY563TR" required
                                                                               autocomplete="false">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="recipient-name"
                                                                               class="col-form-label">Capacidade
                                                                            em kg</label>
                                                                        <input name="capacity" id="capacity"
                                                                               type="number"
                                                                               class="form-control"
                                                                               value="{{ $intervention->capacity ?? '' }}"
                                                                               placeholder="ex: 15" required
                                                                               autocomplete="false">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="pressure-permanente"
                                                                               class="col-form-label">Pressão
                                                                            Permanente:</label>
                                                                        <div class="row">
                                                                            <div class="col-sm-2">
                                                                                <div class="form-check">
                                                                                    <input class="form-check-input"
                                                                                           type="radio"
                                                                                           name="pressure"
                                                                                           id="pressure-yes"
                                                                                           value="1" {{ $intervention->pressure == 1 ? 'checked' : '' }}>
                                                                                    <label class="form-check-label"
                                                                                           for="pressure-yes">Sim</label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-2">
                                                                                <div class="form-check">
                                                                                    <input class="form-check-input"
                                                                                           type="radio"
                                                                                           name="pressure"
                                                                                           id="pressure-no"
                                                                                           value="0" {{ $intervention->pressure == 0 ? 'checked' : '' }}>
                                                                                    <label class="form-check-label"
                                                                                           for="pressure-no">Não</label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="recipient-name"
                                                                               class="col-form-label">Nome
                                                                            do Fabricante</label>
                                                                        <input name="factoryName" id="factoryName"
                                                                               type="text"
                                                                               class="form-control"
                                                                               value="{{ $intervention->factoryName ?? '' }}"
                                                                               placeholder="ex: Empresa X" required
                                                                               autocomplete="false">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="recipient-name"
                                                                               class="col-form-label"> Data
                                                                            de Fabrico</label>
                                                                        <input name="factoryDate" id="factoryDate"
                                                                               type="date"
                                                                               class="form-control"
                                                                               value="{{ $intervention->factoryDate ? date('Y-m-d', strtotime($intervention->factoryDate)) : '' }}"
                                                                               max="{{ date('Y-m-d') }}" required
                                                                               autocomplete="false">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="recipient-name"
                                                                               class="col-form-label">Localização</label>
                                                                        <input name="localization" id="localization"
                                                                               type="text"
                                                                               class="form-control"
                                                                               value="{{ $intervention->localization ?? '' }}"
                                                                               placeholder="ex:Rua X, Nº XXX, andar X"
                                                                               required autocomplete="false">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="recipient-name"
                                                                               class="col-form-label">Ultimo
                                                                            Carregamento</label>
                                                                        <input name="lastCharged" id="lastCharged"
                                                                               type="date"
                                                                               class="form-control"
                                                                               max="{{ date('Y-m-d') }}"
                                                                               value="{{ $intervention->lastCharged ? date('Y-m-d', strtotime($intervention->lastCharged)) : '' }}"
                                                                               required autocomplete="false">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="recipient-name"
                                                                               class="col-form-label">Ultimo
                                                                            teste Hidraulico</label>
                                                                        <input name="lastHydraulicTest"
                                                                               id="lastHydraulicTest"
                                                                               type="date" class="form-control"
                                                                               max="{{ date('Y-m-d') }}"
                                                                               value="{{ $intervention->lastHydraulicTest ? date('Y-m-d', strtotime($intervention->lastHydraulicTest)) : '' }}"
                                                                               required autocomplete="false">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="recipient-name"
                                                                               class="col-form-label">Manutenção
                                                                            MNT</label>
                                                                        <div class="row">
                                                                            <div class="col-sm-2">
                                                                                <div class="form-check">
                                                                                    <input class="form-check-input"
                                                                                           type="radio"
                                                                                           name="maintenanceMNT"
                                                                                           id="maintenanceMNT-yes"
                                                                                           value="1" {{ $intervention->maintenanceMNT == 1 ? 'checked' : '' }}>
                                                                                    <label class="form-check-label"
                                                                                           for="maintenanceMNT-yes">Sim</label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-2">
                                                                                <div class="form-check">
                                                                                    <input class="form-check-input"
                                                                                           type="radio"
                                                                                           name="maintenanceMNT"
                                                                                           id="maintenanceMNT-no"
                                                                                           value="0" {{ $intervention->maintenanceMNT == 0 ? 'checked' : '' }}>
                                                                                    <label class="form-check-label"
                                                                                           for="maintenanceMNT-no">Não</label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="recipient-name"
                                                                               class="col-form-label">Peso
                                                                            CO2 em kg</label>
                                                                        <input name="co2Weight" id="co2Weight"
                                                                               type="number"
                                                                               class="form-control"
                                                                               value="{{ $intervention->co2Weight }}"
                                                                               placeholder="ex:15"
                                                                               required autocomplete="false">
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div
                                                                        style="border-left: 1px solid #ddd; height: 100%;">
                                                                        <!-- Right Column -->
                                                                        <div class="form-group pl-3">
                                                                            <label for="recipient-name"
                                                                                   class="col-form-label">Carregamento
                                                                                MNT AD</label>
                                                                            <div class="row">
                                                                                <div class="col-sm-2">
                                                                                    <div class="form-check">
                                                                                        <input class="form-check-input"
                                                                                               type="radio"
                                                                                               name="chargeMNTAD"
                                                                                               id="chargeMNTAD-yes"
                                                                                               value="1" {{ $intervention->chargeMNTAD == 1 ? 'checked' : '' }}>
                                                                                        <label class="form-check-label"
                                                                                               for="chargeMNTAD-yes">Sim</label>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-2">
                                                                                    <div class="form-check">
                                                                                        <input class="form-check-input"
                                                                                               type="radio"
                                                                                               name="chargeMNTAD"
                                                                                               id="chargeMNTAD-no"
                                                                                               value="0" {{ $intervention->chargeMNTAD == 0 ? 'checked' : '' }}>
                                                                                        <label class="form-check-label"
                                                                                               for="chargeMNTAD-no">Não</label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group pl-3">
                                                                            <label for="recipient-name"
                                                                                   class="col-form-label">Tipo</label>
                                                                            <div class="row">
                                                                                <div class="col-sm-2">
                                                                                    <div class="form-check">
                                                                                        <input class="form-check-input"
                                                                                               type="radio"
                                                                                               name="type"
                                                                                               id="type-yes"
                                                                                               value="C" {{ $intervention->type == 'C' ? 'checked' : '' }}>
                                                                                        <label class="form-check-label"
                                                                                               for="type-yes">C</label>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-2">
                                                                                    <div class="form-check">
                                                                                        <input class="form-check-input"
                                                                                               type="radio"
                                                                                               name="type"
                                                                                               id="type-no"
                                                                                               value="S" {{ $intervention->type == 'S' ? 'checked' : '' }}>
                                                                                        <label class="form-check-label"
                                                                                               for="type-no">S</label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group pl-3">
                                                                            <label for="recipient-name"
                                                                                   class="col-form-label">Prova
                                                                                Hidraulica</label>
                                                                            <div class="row">
                                                                                <div class="col-sm-2">
                                                                                    <div class="form-check">
                                                                                        <input class="form-check-input"
                                                                                               type="radio"
                                                                                               name="hydraulicProve"
                                                                                               id="hydraulicProve-yes"
                                                                                               value="1" {{ $intervention->hydraulicProve == 1 ? 'checked' : '' }}>
                                                                                        <label class="form-check-label"
                                                                                               for="hydraulicProve-yes">Sim</label>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-2">
                                                                                    <div class="form-check">
                                                                                        <input class="form-check-input"
                                                                                               type="radio"
                                                                                               name="hydraulicProve"
                                                                                               id="hydraulicProve-no"
                                                                                               value="0" {{ $intervention->hydraulicProve == 0 ? 'checked' : '' }}>
                                                                                        <label class="form-check-label"
                                                                                               for="hydraulicProve-no">Não</label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group pl-3">
                                                                            <label for="recipient-name"
                                                                                   class="col-form-label">Selo
                                                                                de Segurança</label>
                                                                            <div class="row">
                                                                                <div class="col-sm-2">
                                                                                    <div class="form-check">
                                                                                        <input class="form-check-input"
                                                                                               type="radio"
                                                                                               name="securityStamp"
                                                                                               id="securityStamp-yes"
                                                                                               value="1" {{ $intervention->securityStamp == 1 ? 'checked' : '' }}>
                                                                                        <label class="form-check-label"
                                                                                               for="securityStamp-yes">Sim</label>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-2">
                                                                                    <div class="form-check">
                                                                                        <input class="form-check-input"
                                                                                               type="radio"
                                                                                               name="securityStamp"
                                                                                               id="securityStamp-no"
                                                                                               value="0" {{ $intervention->securityStamp == 0 ? 'checked' : '' }}>
                                                                                        <label class="form-check-label"
                                                                                               for="securityStamp-no">Não</label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group pl-3">
                                                                            <label for="recipient-name"
                                                                                   class="col-form-label">O-Ring</label>
                                                                            <div class="row">
                                                                                <div class="col-sm-2">
                                                                                    <div class="form-check">
                                                                                        <input class="form-check-input"
                                                                                               type="radio"
                                                                                               name="oRing"
                                                                                               id="oRing-yes"
                                                                                               value="1" {{ $intervention->oRing == 1 ? 'checked' : '' }}>
                                                                                        <label class="form-check-label"
                                                                                               for="oRing-yes">Sim</label>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-2">
                                                                                    <div class="form-check">
                                                                                        <input class="form-check-input"
                                                                                               type="radio"
                                                                                               name="oRing"
                                                                                               id="oRing-no"
                                                                                               value="0" {{ $intervention->oRing == 0 ? 'checked' : '' }}>
                                                                                        <label class="form-check-label"
                                                                                               for="oRing-no">Não</label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group pl-3">
                                                                            <label for="peg" class="col-form-label">Cavilha</label>
                                                                            <div class="row">
                                                                                <div class="col-sm-2">
                                                                                    <div class="form-check">
                                                                                        <input class="form-check-input"
                                                                                               type="radio"
                                                                                               name="peg" id="peg-yes"
                                                                                               value="1" {{ $intervention->peg == 1 ? 'checked' : '' }}>
                                                                                        <label class="form-check-label"
                                                                                               for="peg-yes">Sim</label>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-2">
                                                                                    <div class="form-check">
                                                                                        <input class="form-check-input"
                                                                                               type="radio"
                                                                                               name="peg" id="peg-no"
                                                                                               value="0" {{ $intervention->peg == 0 ? 'checked' : '' }}>
                                                                                        <label class="form-check-label"
                                                                                               for="peg-no">Não</label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group pl-3">
                                                                            <label for="recipient-name"
                                                                                   class="col-form-label">Manometro</label>
                                                                            <div class="row">
                                                                                <div class="col-sm-2">
                                                                                    <div class="form-check">
                                                                                        <input class="form-check-input"
                                                                                               type="radio"
                                                                                               name="manometer"
                                                                                               id="manometer-yes"
                                                                                               value="1" {{ $intervention->manometer == 1 ? 'checked' : '' }}>
                                                                                        <label class="form-check-label"
                                                                                               for="manometer-yes">Sim</label>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-2">
                                                                                    <div class="form-check">
                                                                                        <input class="form-check-input"
                                                                                               type="radio"
                                                                                               name="manometer"
                                                                                               id="manometer-no"
                                                                                               value="0" {{ $intervention->manometer == 0 ? 'checked' : '' }}>
                                                                                        <label class="form-check-label"
                                                                                               for="manometer-no">Não</label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group pl-3">
                                                                            <label for="recipient-name"
                                                                                   class="col-form-label">Difusor</label>
                                                                            <div class="row">
                                                                                <div class="col-sm-2">
                                                                                    <div class="form-check">
                                                                                        <input class="form-check-input"
                                                                                               type="radio"
                                                                                               name="diffuser"
                                                                                               id="diffuser-yes"
                                                                                               value="1" {{ $intervention->diffuser == 1 ?  'checked' : '' }}>
                                                                                        <label class="form-check-label"
                                                                                               for="diffuser-yes">Sim</label>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-2">
                                                                                    <div class="form-check">
                                                                                        <input class="form-check-input"
                                                                                               type="radio"
                                                                                               name="diffuser"
                                                                                               id="diffuser-no"
                                                                                               value="0" {{ $intervention->diffuser == 0 ?  'checked' : '' }}>
                                                                                        <label class="form-check-label"
                                                                                               for="diffuser-no">Não</label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group pl-3">
                                                                            <label for="recipient-name"
                                                                                   class="col-form-label">Base
                                                                                Plástica</label>
                                                                            <div class="row">
                                                                                <div class="col-sm-2">
                                                                                    <div class="form-check">
                                                                                        <input class="form-check-input"
                                                                                               type="radio"
                                                                                               name="plasticBase"
                                                                                               id="plasticBase-yes"
                                                                                               value="1" {{ $intervention->plasticBase == 1 ?  'checked' : '' }}>
                                                                                        <label class="form-check-label"
                                                                                               for="plasticBase-yes">Sim</label>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-2">
                                                                                    <div class="form-check">
                                                                                        <input class="form-check-input"
                                                                                               type="radio"
                                                                                               name="plasticBase"
                                                                                               id="plasticBase-no"
                                                                                               value="0" {{ $intervention->plasticBase == 0 ?  'checked' : '' }}>
                                                                                        <label class="form-check-label"
                                                                                               for="plasticBase-no">Não</label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group pl-3">
                                                                            <label for="recipient-name"
                                                                                   class="col-form-label">Rótulo</label>
                                                                            <div class="row">
                                                                                <div class="col-sm-2">
                                                                                    <div class="form-check">
                                                                                        <input class="form-check-input"
                                                                                               type="radio"
                                                                                               name="label"
                                                                                               id="label-yes"
                                                                                               value="1" {{ $intervention->label == 1 ?  'checked' : '' }}>
                                                                                        <label class="form-check-label"
                                                                                               for="label-yes">Sim</label>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-2">
                                                                                    <div class="form-check">
                                                                                        <input class="form-check-input"
                                                                                               type="radio"
                                                                                               name="label"
                                                                                               id="label-no"
                                                                                               value="0" {{ $intervention->label == 0 ?  'checked' : '' }}>
                                                                                        <label class="form-check-label"
                                                                                               for="label-no">Não</label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group pl-3">
                                                                            <label for="recipient-name"
                                                                                   class="col-form-label">Sparkles</label>
                                                                            <div class="row">
                                                                                <div class="col-sm-2">
                                                                                    <div class="form-check">
                                                                                        <input class="form-check-input"
                                                                                               type="radio"
                                                                                               name="sparkles"
                                                                                               id="sparkles-yes"
                                                                                               value="1" {{ $intervention->sparkles == 1 ?  'checked' : '' }}>
                                                                                        <label class="form-check-label"
                                                                                               for="sparkles-yes">Sim</label>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-2">
                                                                                    <div class="form-check">
                                                                                        <input class="form-check-input"
                                                                                               type="radio"
                                                                                               name="sparkles"
                                                                                               id="sparkles-no"
                                                                                               value="0" {{ $intervention->sparkles == 0 ?  'checked' : '' }}>
                                                                                        <label class="form-check-label"
                                                                                               for="sparkles-no">Não</label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group pl-3">
                                                                            <label for="recipient-name"
                                                                                   class="col-form-label">Approved</label>
                                                                            <div class="row">
                                                                                <div class="col-sm-2">
                                                                                    <div class="form-check">
                                                                                        <input class="form-check-input"
                                                                                               type="radio"
                                                                                               name="approved"
                                                                                               id="approved-yes"
                                                                                               value="1" {{ $intervention->approved == 1 ?  'checked' : '' }}>
                                                                                        <label class="form-check-label"
                                                                                               for="approved-yes">Sim</label>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-2">
                                                                                    <div class="form-check">
                                                                                        <input class="form-check-input"
                                                                                               type="radio"
                                                                                               name="approved"
                                                                                               id="approved-no"
                                                                                               value="0"{{ $intervention->approved == 0 ?  'checked' : '' }}>
                                                                                        <label class="form-check-label"
                                                                                               for="approved-no">Não</label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group pl-3">
                                                                            <label for="recipient-name"
                                                                                   class="col-form-label">Fora
                                                                                de Serviço</label>
                                                                            <div class="row">
                                                                                <div class="col-sm-2">
                                                                                    <div class="form-check">
                                                                                        <input class="form-check-input"
                                                                                               type="radio"
                                                                                               name="outofservice"
                                                                                               id="outofservice-yes"
                                                                                               value="1" {{ $intervention->outofservice == 1 ?  'checked' : '' }}>
                                                                                        <label class="form-check-label"
                                                                                               for="outofservice-yes">Sim</label>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-2">
                                                                                    <div class="form-check">
                                                                                        <input class="form-check-input"
                                                                                               type="radio"
                                                                                               name="outofservice"
                                                                                               id="outofservice-no"
                                                                                               value="0"{{ $intervention->outofservice == 0 ?  'checked' : '' }}>
                                                                                        <label class="form-check-label"
                                                                                               for="outofservice-no">Não</label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group pl-3">
                                                                            <label for="new"
                                                                                   class="col-form-label">Novo</label>
                                                                            <div class="row">
                                                                                <div class="col-sm-2">
                                                                                    <div class="form-check">
                                                                                        <input class="form-check-input"
                                                                                               type="radio"
                                                                                               name="new" id="new-yes"
                                                                                               value="1" {{ $intervention->new == 1 ? 'checked' : '' }}>
                                                                                        <label class="form-check-label"
                                                                                               for="new-yes">Sim</label>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-2">
                                                                                    <div class="form-check">
                                                                                        <input class="form-check-input"
                                                                                               type="radio"
                                                                                               name="new" id="new-no"
                                                                                               value="0" {{ $intervention->new == 0 ? 'checked' : '' }}>
                                                                                        <label class="form-check-label"
                                                                                               for="new-no">Não</label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group pl-3">
                                                                            <label for="recipient-name"
                                                                                   class="col-form-label">Motivo
                                                                                de Rejeição</label>
                                                                            <textarea name="rejectedMotive"
                                                                                      id="rejectedMotive"
                                                                                      type="text"
                                                                                      class="form-control"
                                                                                      placeholder="ex: Foi rejeitado porque..."
                                                                                      autocomplete="false">{{$intervention->rejectedMotive}}</textarea>
                                                                        </div>
                                                                        <div class="form-group pl-3">
                                                                            <label for="recipient-name"
                                                                                   class="col-form-label">Observações</label>
                                                                            <textarea name="observations"
                                                                                      id="observations"
                                                                                      type="text"
                                                                                      class="form-control" value=""
                                                                                      placeholder="Escrever observações extra"
                                                                                      autocomplete="false">{{$intervention->observations}}</textarea>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button"
                                                                                    class="btn btn-secondary"
                                                                                    data-dismiss="modal">Fechar
                                                                            </button>
                                                                            <button type="submit"
                                                                                    class="btn btn-custom">Atualizar
                                                                                Intervenção
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <script>
                                            document.addEventListener('DOMContentLoaded', function () {
                                                const carDropdown = document.getElementById('car_dropdown_Edit_{{ $intervention->id }}');
                                                const carIdSelect = document.getElementById('car_id_Edit_{{ $intervention->id }}');
                                                const placeYes = document.getElementById('place_yes_Edit_{{ $intervention->id }}');
                                                const placeNo = document.getElementById('place_no_Edit_{{ $intervention->id }}');

                                                if (placeYes.checked) {
                                                    //console.log('loja');
                                                    carDropdown.style.display = 'none';
                                                } else if (placeNo.checked) {
                                                    //  console.log('carro');
                                                    carDropdown.style.display = 'block';
                                                }

                                                placeNo.addEventListener('click', function () {
                                                    carDropdown.style.display = 'block';
                                                    carIdSelect.required = true;
                                                });

                                                placeYes.addEventListener('click', function () {
                                                    carDropdown.style.display = 'none';
                                                    carIdSelect.required = false;
                                                });
                                            });
                                        </script>
                                    @else
                                        <a href="{{ route('invoice.pdf', $intervention->invoice_id) }}"
                                           class="btn btn-outline-danger btn-icon animated-hover"
                                           data-placement="top" title="Download Fatura">
                                            <i class="fas fa-file-download"></i>
                                        </a>
                                        <a style="pointer-events: none"
                                           class="btn btn-outline-secondary btn-icon animated-hover"
                                           data-placement="top" title="Editar Intervenção">
                                            <i class="far fa-edit"></i>
                                        </a>
                                        <a style="pointer-events: none"
                                           class="btn btn-outline-secondary btn-icon animated-hover"
                                           data-placement="top" title="Eliminar Intervenção">
                                            <i class="far fa-trash-alt"></i>
                                        </a>

                                        <!-- Send invoice by email-->
                                        <div class="modal fade" id="sendInvoice-{{ $intervention->id }}" tabindex="-1"
                                             role="dialog" aria-labelledby="sendInvoiceModal" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="sendEmailModalLabel">Enviar Fatura
                                                            por E-mail</h5>
                                                        <button type="button" class="close"
                                                                id="closeBtn-{{ $intervention->id }}"
                                                                data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div id="spinner-{{ $intervention->id }}" class="text-center"
                                                             style="display: none;">
                                                            <i class="fa fa-spinner fa-spin"></i> A enviar fatura...
                                                        </div>

                                                        <div id="formWrapper-{{ $intervention->id }}">
                                                            <form id="sendEmailForm-{{ $intervention->id }}"
                                                                  method="POST"
                                                                  action="{{ route('intervention.sendInvoice', $intervention->invoice_id) }}">
                                                                @csrf
                                                                <div class="form-group row">
                                                                    <label for="email-{{ $intervention->id }}"
                                                                           class="col-sm-3 col-form-label">E-mail</label>
                                                                    <div class="col-sm-9">
                                                                        <input type="email" class="form-control"
                                                                               id="email-{{ $intervention->id }}"
                                                                               name="email" required>
                                                                        <!--Empty email input error message -->
                                                                        <p id="emailError-{{ $intervention->id }}"
                                                                           style="color:red;"></p>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal"
                                                                id="cancelBtn-{{ $intervention->id }}">Cancelar
                                                        </button>
                                                        <button type="button" class="btn btn-custom"
                                                                id="sendBtn-{{ $intervention->id }}"
                                                                onclick="sendEmail{{ $intervention->id }}()">Enviar
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <script>
                                            function sendEmail{{ $intervention->id }}() {
                                                var sendBtn = document.getElementById('sendBtn-{{ $intervention->id }}');
                                                var cancelBtn = document.getElementById('cancelBtn-{{ $intervention->id }}');
                                                var closeBtn = document.getElementById('closeBtn-{{ $intervention->id }}');
                                                var sendEmailForm = document.getElementById('sendEmailForm-{{ $intervention->id }}');
                                                var emailInput = document.getElementById('email-{{ $intervention->id }}');
                                                var emailError = document.getElementById('emailError-{{ $intervention->id }}');
                                                var spinner = document.getElementById('spinner-{{ $intervention->id }}');
                                                var formWrapper = document.getElementById('formWrapper-{{ $intervention->id }}');

                                                // Check if the email input is empty
                                                if (emailInput.value === '') {
                                                    emailError.textContent = 'Preencha o campo e-mail';
                                                    return; // Exit the function if the input is empty
                                                } else {
                                                    emailError.textContent = ''; // Clear the error message if the input is not empty
                                                }

                                                sendBtn.disabled = true; // Disable the button
                                                cancelBtn.disabled = true;
                                                closeBtn.style.display = "none";
                                                sendBtn.innerHTML = 'A Enviar Fatura...'; // Change the button text to indicate sending

                                                // Hide the form and show the spinner
                                                formWrapper.style.display = 'none';
                                                spinner.style.display = 'block';

                                                // Submit the form using AJAX
                                                $.ajax({
                                                    url: sendEmailForm.action,
                                                    type: 'POST',
                                                    data: new FormData(sendEmailForm),
                                                    processData: false,
                                                    contentType: false,
                                                    // Success callback
                                                    success: function (response) {
                                                        // Close the send invoice modal
                                                        sendBtn.disabled = false; // Enable the button
                                                        cancelBtn.disabled = false;
                                                        closeBtn.style.display = "block";
                                                        sendBtn.innerHTML = 'Enviar'; // Change the button text to indicate sending
                                                        $('#sendInvoice-{{ $intervention->id }}').modal('hide');

                                                        // Show success message after a short delay
                                                        setTimeout(function () {
                                                            $('#sendEmailSuccessModal').modal('show');
                                                        }, 500);

                                                        // Reset the form
                                                        sendEmailForm.reset();

                                                        // Hide the spinner and show the form
                                                        spinner.style.display = 'none';
                                                        formWrapper.style.display = 'block';
                                                    },
                                                    // Error callback
                                                    error: function (xhr, status, error) {
                                                        // Close the send invoice modal
                                                        sendBtn.disabled = false; // Enable the button
                                                        cancelBtn.disabled = false;
                                                        closeBtn.style.display = "block";
                                                        sendBtn.innerHTML = 'Enviar'; // Change the button text to indicate sending
                                                        $('#sendInvoice-{{ $intervention->id }}').modal('hide');

                                                        // Show error message after a short delay
                                                        setTimeout(function () {
                                                            $('#sendEmailErrorModal').modal('show');
                                                        }, 500);

                                                        // Reset the button text and enable the button
                                                        sendBtn.disabled = false;
                                                        sendBtn.innerHTML = 'Enviar';

                                                        // Reset the form
                                                        sendEmailForm.reset();

                                                        // Hide the spinner and show the form
                                                        spinner.style.display = 'none';
                                                        formWrapper.style.display = 'block';
                                                    }
                                                });
                                            }
                                        </script>

                                        <!-- Success message modal -->
                                        <div class="modal fade" id="sendEmailSuccessModal" tabindex="-1" role="dialog"
                                             aria-labelledby="sendEmailSuccessModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-body">
                                                        Fatura enviada por e-mail com sucesso.
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-custom"
                                                                data-dismiss="modal">Fechar
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Error message modal -->
                                        <div class="modal fade" id="sendEmailErrorModal" tabindex="-1" role="dialog"
                                             aria-labelledby="sendEmailErrorModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-body">
                                                        Ocorreu um erro ao enviar a fatura por e-mail.
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-custom"
                                                                data-dismiss="modal">Fechar
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    @endif
                                    <a href="{{ route('intervention.view', $intervention->id) }}"
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
            @if ($interventions->hasPages())
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                        {{-- Previous Page Link --}}
                        @if ($interventions->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link">Anterior</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $interventions->previousPageUrl() }}"
                                   rel="prev">Anterior</a>
                            </li>
                        @endif
                        {{-- Pagination Elements --}}
                        @foreach (range(1, $interventions->lastPage()) as $page)
                            @if ($page == $interventions->currentPage())
                                <li class="page-item active">
                                    <span class="page-link">{{ $page }}</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $interventions->url($page) }}">{{ $page }}</a>
                                </li>
                            @endif
                        @endforeach
                        {{-- Next Page Link --}}
                        @if ($interventions->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $interventions->nextPageUrl() }}" rel="next">Próximo</a>
                            </li>
                        @else
                            <li class="page-item disabled">
                                <span class="page-link">Próximo</span>
                            </li>
                        @endif
                    </ul>
                </nav>
            @endif
        @endif
    </div>

    <!-- Create Intervention -->
    <div class="modal fade" id="newIntervention" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Criar Intervenção</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form autocomplete="off" method="post" action="{{route('intervention.create')}}">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <!-- Left Column -->
                                <div class="form-group">
                                    <label for="place" class="col-form-label">Pedido Efetuado em</label>
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="place"
                                                       id="place-yes"
                                                       value="1" required>
                                                <label class="form-check-label" for="place-yes">Loja</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="place"
                                                       id="place-no"
                                                       value="0" required>
                                                <label class="form-check-label" for="place-no">Cliente</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group" id="car-dropdown" style="display: none;">
                                    <label for="car" class="col-form-label">Escolha o veículo utilizado:</label>
                                    <select class="form-control" name="car_id" id="car_id">
                                        <option value="" selected>Escolher matricula</option>
                                        @foreach ($cars as $car)
                                            <option value="{{ $car->id }}">{{ $car->brand}}
                                                - {{ $car->licensePlate }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="client_id" class="col-form-label">Escolha o cliente:</label>
                                    <select class="form-control" name="client_id" id="client_id" required>
                                        <option value="">Escolher Cliente</option>
                                        @if($clients)
                                            @foreach($clients as $client)
                                                <option value="{{ $client['id'] }}">{{ $client['name'] }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="ceMarking" class="col-form-label">Marcação CE</label>
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="ceMarking"
                                                       id="ceMarking-yes"
                                                       value="1" checked required>
                                                <label class="form-check-label" for="ceMarking-yes">Sim</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="ceMarking"
                                                       id="ceMarking-no"
                                                       value="0" required>
                                                <label class="form-check-label" for="ceMarking-no">Não</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Número Interno</label>
                                    <input name="internalNumber" id="internalNumber" type="number"
                                           class="form-control" value="" placeholder="ex: 1"
                                           required autocomplete="false">
                                </div>
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Tipo de Agente do
                                        extintor</label>
                                    <select class="form-control" name="fluid_type_id" id="fluid_type_id" required>
                                        <option value="" selected>Escolher tipo de Fluido</option>
                                        @foreach ($fluid_types as $fluid_type)
                                            <option value="{{ $fluid_type->id }}">{{ $fluid_type->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label"> Numero de Série</label>
                                    <input name="serialNumber" id="serialNumber" type="text"
                                           class="form-control" value="" placeholder="ex: 1ABY563TR"
                                           required autocomplete="false">
                                </div>
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Capacidade em kg</label>
                                    <input name="capacity" id="capacity" type="number"
                                           class="form-control" value="" placeholder="ex: 15"
                                           required autocomplete="false">
                                </div>
                                <div class="form-group">
                                    <label for="pressure-permanente" class="col-form-label">Pressão
                                        Permanente:</label>
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="pressure"
                                                       id="pressure-yes"
                                                       value="1" required>
                                                <label class="form-check-label" for="pressure-yes">Sim</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="pressure"
                                                       id="pressure-no"
                                                       value="0" required>
                                                <label class="form-check-label" for="pressure-no">Não</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Nome do
                                        Fabricante</label>
                                    <input name="factoryName" id="factoryName" type="text"
                                           class="form-control" value="" placeholder="ex: Empresa X"
                                           required autocomplete="false">
                                </div>
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label"> Data de Fabrico</label>
                                    <input name="factoryDate" id="factoryDate" type="date" class="form-control"
                                           value=""
                                           max="{{ date('Y-m-d') }}" required autocomplete="false">
                                </div>
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Localização</label>
                                    <input name="localization" id="localization" type="text"
                                           class="form-control" value="" placeholder="ex:Rua X, Nº XXX, andar X"
                                           required autocomplete="false">
                                </div>
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Ultimo
                                        Carregamento</label>
                                    <input name="lastCharged" id="lastCharged" type="date"
                                           class="form-control" value="" max="{{ date('Y-m-d') }}"
                                           required autocomplete="false">
                                </div>
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Ultimo teste
                                        Hidraulico</label>
                                    <input name="lastHydraulicTest" id="lastHydraulicTest" type="date"
                                           class="form-control" value="" max="{{ date('Y-m-d') }}"
                                           required autocomplete="false">
                                </div>
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Manutenção MNT</label>
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio"
                                                       name="maintenanceMNT"
                                                       id="maintenanceMNT-yes"
                                                       value="1" required>
                                                <label class="form-check-label"
                                                       for="maintenanceMNT-yes">Sim</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio"
                                                       name="maintenanceMNT"
                                                       id="maintenanceMNT-no"
                                                       value="0" required>
                                                <label class="form-check-label"
                                                       for="maintenanceMNT-no">Não</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Peso CO2 em kg</label>
                                    <input name="co2Weight" id="co2Weight" type="number"
                                           class="form-control" value="" placeholder="ex:15"
                                           required autocomplete="false">
                                </div>

                            </div>
                            <div class="col-lg-6">
                                <div style="border-left: 1px solid #ddd; height: 100%;">
                                    <!-- Right Column -->
                                    <div class="form-group pl-3">
                                        <label for="recipient-name" class="col-form-label">Carregamento MNT
                                            AD</label>
                                        <div class="row">
                                            <div class="col-sm-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="chargeMNTAD"
                                                           id="chargeMNTAD-yes"
                                                           value="1" required>
                                                    <label class="form-check-label"
                                                           for="chargeMNTAD-yes">Sim</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="chargeMNTAD"
                                                           id="chargeMNTAD-no"
                                                           value="0" required>
                                                    <label class="form-check-label" for="chargeMNTAD-no">Não</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group pl-3">
                                        <label for="recipient-name" class="col-form-label">Tipo</label>
                                        <div class="row">
                                            <div class="col-sm-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="type"
                                                           id="type-yes"
                                                           value="C" required>
                                                    <label class="form-check-label" for="type-yes">C</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="type"
                                                           id="type-no"
                                                           value="S" required>
                                                    <label class="form-check-label" for="type-no">S</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group pl-3">
                                        <label for="recipient-name" class="col-form-label">Prova Hidraulica</label>
                                        <div class="row">
                                            <div class="col-sm-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio"
                                                           name="hydraulicProve"
                                                           id="hydraulicProve-yes"
                                                           value="1" required>
                                                    <label class="form-check-label"
                                                           for="hydraulicProve-yes">Sim</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio"
                                                           name="hydraulicProve"
                                                           id="hydraulicProve-no"
                                                           value="0" required>
                                                    <label class="form-check-label"
                                                           for="hydraulicProve-no">Não</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group pl-3">
                                        <label for="recipient-name" class="col-form-label">Selo de Segurança</label>
                                        <div class="row">
                                            <div class="col-sm-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio"
                                                           name="securityStamp"
                                                           id="securityStamp-yes"
                                                           value="1" required>
                                                    <label class="form-check-label"
                                                           for="securityStamp-yes">Sim</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio"
                                                           name="securityStamp"
                                                           id="securityStamp-no"
                                                           value="0" required>
                                                    <label class="form-check-label"
                                                           for="securityStamp-no">Não</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group pl-3">
                                        <label for="recipient-name" class="col-form-label"> O-Ring</label>
                                        <div class="row">
                                            <div class="col-sm-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="oRing"
                                                           id="oRing-yes"
                                                           value="1" required>
                                                    <label class="form-check-label" for="oRing-yes">Sim</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="oRing"
                                                           id="oRing-no"
                                                           value="0" required>
                                                    <label class="form-check-label" for="oRing-no">Não</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group pl-3">
                                        <label for="peg" class="col-form-label">Cavilha</label>
                                        <div class="row">
                                            <div class="col-sm-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="peg"
                                                           id="peg-yes"
                                                           value="1" required>
                                                    <label class="form-check-label" for="peg-yes">Sim</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="peg"
                                                           id="peg-no"
                                                           value="0" required>
                                                    <label class="form-check-label" for="peg-no">Não</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group pl-3">
                                        <label for="recipient-name" class="col-form-label">Manometro</label>
                                        <div class="row">
                                            <div class="col-sm-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="manometer"
                                                           id="manometer-yes"
                                                           value="1" required>
                                                    <label class="form-check-label" for="manometer-yes">Sim</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="manometer"
                                                           id="manometer-no"
                                                           value="0" required>
                                                    <label class="form-check-label" for="manometer-no">Não</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group pl-3">
                                        <label for="recipient-name" class="col-form-label">Difusor</label>
                                        <div class="row">
                                            <div class="col-sm-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="diffuser"
                                                           id="diffuser-yes"
                                                           value="1" required>
                                                    <label class="form-check-label" for="diffuser-yes">Sim</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="diffuser"
                                                           id="diffuser-no"
                                                           value="0" required>
                                                    <label class="form-check-label" for="diffuser-no">Não</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group pl-3">
                                        <label for="recipient-name" class="col-form-label">Base Plástica</label>
                                        <div class="row">
                                            <div class="col-sm-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="plasticBase"
                                                           id="plasticBase-yes"
                                                           value="1" required>
                                                    <label class="form-check-label"
                                                           for="plasticBase-yes">Sim</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="plasticBase"
                                                           id="plasticBase-no"
                                                           value="0" required>
                                                    <label class="form-check-label" for="plasticBase-no">Não</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group pl-3">
                                        <label for="recipient-name" class="col-form-label">Rótulo</label>
                                        <div class="row">
                                            <div class="col-sm-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="label"
                                                           id="label-yes"
                                                           value="1" required>
                                                    <label class="form-check-label" for="label-yes">Sim</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="label"
                                                           id="label-no"
                                                           value="0" required>
                                                    <label class="form-check-label" for="label-no">Não</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group pl-3">
                                        <label for="recipient-name" class="col-form-label">Sparkles</label>
                                        <div class="row">
                                            <div class="col-sm-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="sparkles"
                                                           id="sparkles-yes"
                                                           value="1" required>
                                                    <label class="form-check-label" for="sparkles-yes">Sim</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="sparkles"
                                                           id="sparkles-no"
                                                           value="0" required>
                                                    <label class="form-check-label" for="sparkles-no">Não</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group pl-3">
                                        <label for="recipient-name" class="col-form-label">Aprovado</label>
                                        <div class="row">
                                            <div class="col-sm-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="approved"
                                                           id="approved-yes"
                                                           value="1" required>
                                                    <label class="form-check-label" for="approved-yes">Sim</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="approved"
                                                           id="approved-no"
                                                           value="0" required>
                                                    <label class="form-check-label" for="approved-no">Não</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group pl-3">
                                        <label for="recipient-name" class="col-form-label">Fora de Serviço</label>
                                        <div class="row">
                                            <div class="col-sm-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="outofservice"
                                                           id="outofservice-yes"
                                                           value="1" required>
                                                    <label class="form-check-label"
                                                           for="outofservice-yes">Sim</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="outofservice"
                                                           id="outofservice-no"
                                                           value="0" required>
                                                    <label class="form-check-label"
                                                           for="outofservice-no">Não</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group pl-3">
                                        <label for="recipient-name" class="col-form-label">Novo</label>
                                        <div class="row">
                                            <div class="col-sm-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="new"
                                                           id="new-yes"
                                                           value="1" required>
                                                    <label class="form-check-label" for="new-yes">Sim</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="new"
                                                           id="new-no"
                                                           value="0" required>
                                                    <label class="form-check-label" for="new-no">Não</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group pl-3">
                                        <label for="recipient-name" class="col-form-label">Motivo de
                                            Rejeição</label>
                                        <textarea name="rejectedMotive" id="rejectedMotive" type="text"
                                                  class="form-control" placeholder="ex: Foi rejeitado porque..."
                                                  autocomplete="false"></textarea>
                                    </div>
                                    <div class="form-group pl-3">
                                        <label for="recipient-name" class="col-form-label">Observações</label>
                                        <textarea name="observations" id="observations" type="text"
                                                  class="form-control" placeholder="Escrever observações extra"
                                                  autocomplete="false"></textarea>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar
                                        </button>
                                        <button type="submit" class="btn btn-custom">Criar Intervenção</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--Check if filters are applied-->
    @if (isset($filtersApplied))
        <!-- Filter Modal -->
        <div class="modal fade" id="filterModal" tabindex="-1" role="dialog"
             aria-labelledby="filterModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="filterModalLabel">Filtros</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="filterForm" method="GET" action="{{ route('interventions.filter') }}"
                              class="form-horizontal">
                            <div class="form-group row">
                                <label for="filter-user" class="col-sm-3 col-form-label">Técnico</label>
                                <div class="col-sm-9">
                                    <select class="form-control" id="filter-user" name="user">
                                        @if (isset($filters['user']) && $filters['user'])
                                            <option
                                                value="{{ $users->find($filters['user'])->id }}">{{ $users->find($filters['user'])->name }}</option>
                                        @else
                                            <option value="">todos</option>
                                        @endif
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="filter-client" class="col-sm-3 col-form-label">Cliente</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="client_id" id="client_id">
                                        @if ($filters['client_id'])
                                            <option
                                                value="{{ $filters['client_id'] }}">{{ collect($clients)->where('id', $filters['client_id'])->pluck('name')->first() }}</option>
                                        @else
                                            <option value="">Escolher um Cliente</option>
                                        @endif

                                        @if($clients)
                                            @foreach($clients as $client)
                                                <option
                                                    value="{{ $client['id'] }}">{{ $client['name'] }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="filter-id-invoice" class="col-sm-3 col-form-label">ID da
                                    Fatura</label>
                                <div class="col-sm-9">
                                    @if ($filters['id_invoice'])
                                        <input type="text" class="form-control" id="filter-id-invoice"
                                               name="id_invoice" value="{{ $filters['id_invoice'] }}">
                                    @else
                                        <input type="text" class="form-control" id="filter-id-invoice"
                                               name="id_invoice" value="">
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="filter-approved"
                                       class="col-sm-3 col-form-label">Aprovado</label>
                                <div class="col-sm-9">
                                    <select class="form-control" id="filter-approved" name="approved">
                                        @if (isset($filters['approved']))
                                            <option {{ $filters['approved'] == 1 ? 'Sim' : 'Não' }}>{{ $filters['approved'] == 1 ? 'Sim' : 'Não' }}</option>
                                        @else
                                            <option value="">Todos</option>
                                        @endif
                                        <option value="1">Sim</option>
                                        <option value="0">Não</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="filter-start-date" class="col-sm-3 col-form-label">Intervalo de
                                    Datas</label>
                                @if ($filters['start_date'])
                                    <div class="col-sm-9">
                                        <div class="input-group">
                                            <input type="date" class="form-control" id="filter-start-date"
                                                   name="start_date"
                                                   placeholder="Data inicial"
                                                   value="{{ $filters['start_date'] }}">
                                            <div class="input-group-append">
                                                <span class="input-group-text">até</span>
                                            </div>
                                            <input type="date" class="form-control" id="filter-end-date"
                                                   name="end_date"
                                                   placeholder="Data final"
                                                   value="{{ $filters['end_date'] }}">
                                        </div>
                                    </div>
                                @else
                                    <div class="col-sm-9">
                                        <div class="input-group">
                                            <input type="date" class="form-control" id="filter-start-date"
                                                   name="start_date"
                                                   placeholder="Data inicial">
                                            <div class="input-group-append">
                                                <span class="input-group-text">até</span>
                                            </div>
                                            <input type="date" class="form-control" id="filter-end-date"
                                                   name="end_date"
                                                   placeholder="Data final">
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                        <a href="{{ route('interventions') }}" class="btn btn-info">Limpar
                            filtros</a>
                        <button type="submit" class="btn btn-custom" form="filterForm">Aplicar Filtros
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!--Filter Modal-->
    <div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="filterModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="filterModalLabel">Filtros</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="filterForm" method="GET" action="{{ route('interventions.filter') }}"
                          class="form-horizontal">
                        <div class="form-group row">
                            <label for="filter-user" class="col-sm-3 col-form-label">Técnico</label>
                            <div class="col-sm-9">
                                <select class="form-control" id="filter-user" name="user">
                                    <option value="">Todos</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="filter-client" class="col-sm-3 col-form-label">Cliente</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="client_id" id="client_id">
                                    <option value="">Escolher um Cliente</option>
                                    @if($clients)
                                        @foreach($clients as $client)
                                            <option
                                                value="{{ $client['id'] }}">{{ $client['name'] }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="filter-id-invoice" class="col-sm-3 col-form-label">ID da
                                Fatura</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="filter-id-invoice"
                                       name="id_invoice">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="filter-approved" class="col-sm-3 col-form-label">Aprovado</label>
                            <div class="col-sm-9">
                                <select class="form-control" id="filter-approved" name="approved">
                                    <option value="">Todos</option>
                                    <option value="1">Sim</option>
                                    <option value="0">Não</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="filter-start-date" class="col-sm-3 col-form-label">Intervalo de
                                Datas</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <input type="date" class="form-control" id="filter-start-date"
                                           name="start_date"
                                           placeholder="Data inicial">
                                    <div class="input-group-append">
                                        <span class="input-group-text">até</span>
                                    </div>
                                    <input type="date" class="form-control" id="filter-end-date"
                                           name="end_date"
                                           placeholder="Data final">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-custom" form="filterForm">Aplicar Filtros</button>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('vendor/jquery/jquery.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const carDropdown = document.getElementById('car-dropdown');
            const carIdSelect = document.getElementById('car_id');
            const placeYes = document.getElementById('place-yes');
            const placeNo = document.getElementById('place-no');

            carDropdown.style.display = 'none';

            placeNo.addEventListener('click', function () {
                carDropdown.style.display = 'block';
                carIdSelect.required = true;
            });

            placeYes.addEventListener('click', function () {
                carDropdown.style.display = 'none';
                carIdSelect.required = false;
                carIdSelect.value = ""; // Reset the value
            });
        });
    </script>

    <script>
        setTimeout(function () {
            location.reload();
        }, 180000); // Refresh every 16 minutes 1000000
    </script>

@endsection








