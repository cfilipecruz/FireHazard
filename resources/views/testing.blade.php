@extends('adminlte::page')

@section('title', 'Fire Hazard')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Testing Scenarios</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="{{ route('test.default') }}" class="btn btn-primary btn-block mb-3">Test
                                Default</a>
                            <a href="{{ route('forceSessionExpiration') }}" class="btn btn-success btn-block mb-3">Forçar
                                expirar</a>
                            <a href="{{ route('test.validation') }}" class="btn btn-warning btn-block mb-3">Test
                                Validation</a>
                            <a href="{{ route('test.api') }}" class="btn btn-info btn-block mb-3">Test API</a>

                            <a href="{{ route('test.performance') }}" class="btn btn-danger btn-block">Test
                                Performance</a>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('test.button6') }}" class="btn btn-secondary btn-block mb-3">Test Button
                                6</a>
                            <a href="{{ route('test.button7') }}" class="btn btn-secondary btn-block mb-3">Test Button
                                7</a>
                            <a href="{{ route('test.button8') }}" class="btn btn-secondary btn-block mb-3">Test Button
                                8</a>
                            <a href="{{ route('test.button9') }}" class="btn btn-secondary btn-block mb-3">Test Button
                                9</a>
                            <a href="{{ route('test.button10') }}" class="btn btn-secondary btn-block">Test Button
                                10</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
