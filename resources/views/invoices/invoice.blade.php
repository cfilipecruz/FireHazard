@extends('adminlte::page')

@section('content')

    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">

    <div class="container pt-4">

        <h1>Número da Fatura {{$invoice['ID_Fatura']}}</h1>
        <table class="table table-bordered">
            <tbody>
            <tr>
                <td><strong>Cliente:</strong></td>
                <td>{{$invoice['Cliente']}}</td>
            </tr>
            <tr>
                <td><strong>Número de Identificação Fiscal:</strong></td>
                <td>{{$invoice['Nif']}}</td>
            </tr>
            <tr>
                <td><strong>Endereço:</strong></td>
                <td>{{$invoice['EnderecoCliente']}}</td>
            </tr>
            <tr>
                <td><strong>Código Postal:</strong></td>
                <td>{{$invoice['CodigoPostalCliente']}}</td>
            </tr>
            <tr>
                <td><strong>Cidade:</strong></td>
                <td>{{$invoice['CidadeCliente']}}</td>
            </tr>
            <tr>
                <td><strong>Região:</strong></td>
                <td>{{$invoice['RegiaoCliente']}}</td>
            </tr>
            <tr>
                <td><strong>País:</strong></td>
                <td>{{$invoice['PaisCliente']}}</td>
            </tr>
            <tr>
                <td><strong>Moeda:</strong></td>
                <td>{{$invoice['Moeda']}}</td>
            </tr>
            <tr>
                <td><strong>Data da Fatura:</strong></td>
                <td>{{$invoice['Data']}}</td>
            </tr>
            <tr>
                <td><strong>Data de Vencimento:</strong></td>
                <td>{{$invoice['Validade']}}</td>
            </tr>
            <tr>
                <td><strong>Total a Pagar:</strong></td>
                <td>{{$invoice['TotalPagar']}}</td>
            </tr>
            <tr>
                <td><strong>Estado da Fatura:</strong></td>
                <td>{{$invoice['Estado']}}</td>
            </tr>
            <tr>
                <td><strong>Saldo:</strong></td>
                <td>{{$invoice['SaldoNC']}}</td>
            </tr>
            <tr>
                <td><strong>Email:</strong></td>
                <td>{{$invoice['EmailCliente']}}</td>
            </tr>
            </tbody>
        </table>

    </div>

@endsection
