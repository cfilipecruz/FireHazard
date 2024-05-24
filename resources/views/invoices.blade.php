@extends('adminlte::page')

@section('title', 'Fire Hazard')

@section('content')

    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">

    <div class="container pt-4">

        <h1>Faturas</h1>
        <table class="table table-bordered">
            <thead>
            <tr class="text-center">
                <th>ID</th>
                <th>Nome</th>
                <th>NIF</th>
                <th>Data</th>
                <th>Expiração</th>
                <th>Total</th>
                <th>Status</th>
                <th>Email</th>
                <th>Ver Mais</th>
            </tr>
            </thead>
            <tbody>
            <!-- Loop through the invoices and generate a row for each one -->
            @foreach ($invoices as $invoice)
                <tr class="text-center">
                    <td>{{ $invoice['id'] }}</td>
                    <td>{{ $invoice['name'] }}</td>
                    <td>{{ $invoice['vatNumber'] }}</td>
                    <td>{{ $invoice['dateFormatted'] }}</td>
                    <td>{{ $invoice['expirationFormatted'] }}</td>
                    <td>{{ $invoice['total'] }}</td>
                    <td>{{ $invoice['status'] }}</td>
                    <td>{{ $invoice['emailClient'] }}</td>
                    <td>
                        <a href="{{ route('invoice.view', $invoice['id']) }}" class="btn btn-danger">
                            Ver Mais
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>

@endsection
