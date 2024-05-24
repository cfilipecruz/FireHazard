@extends('adminlte::page')

@section('content')

    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">

    <div class="container-fluid pt-3">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-danger text-white">
                        <h4 class="mb-0">Veiculo Numero {{$car->id}}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="brand">Marca</label>
                                    <p class="form-control-static">{{$car->brand}}</p>
                                </div>
                                <div class="form-group">
                                    <label for="model">Modelo</label>
                                    <p class="form-control-static">{{$car->model}}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="licensePlate">Matricula</label>
                                    <p class="form-control-static">{{$car->licensePlate}}</p>
                                </div>
                                <div class="form-group">
                                    <label for="createdAt">Data de Criação</label>
                                    <p class="form-control-static">{{$car->created_at->format('d/m/Y H:i:s')}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        @if(!$interventionsCount)
                            <a data-toggle="modal" data-target="#editCar" class="btn btn-custom">Editar</a>
                            <a type="button" class="btn btn-custom" data-toggle="modal"
                               data-target="#deleteCar">Eliminar</a>
                        @else
                            <button data-toggle="modal" class="btn btn-custom" disabled>Editar</button>
                            <button type="button" class="btn btn-custom" disabled>Eliminar</button>
                        @endif
                        <a href="{{ route('cars') }}" class="btn btn-secondary">Voltar Atrás</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <!--Edit Car-->
    <div class="modal fade" id="editCar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Atualizar Veiculo nº {{$car->id}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form autocomplete="off" id="carForm" method="post" action="{{route('car.update', $car->id)}}">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputPassword1">Marca</label>
                            <input name="brand" type="text" class="form-control"
                                   placeholder="ex: Renault" required autocomplete="false" value="{{$car->brand}}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Modelo</label>
                            <input name="model" type="text" class="form-control"
                                   placeholder="ex: Clio" required autocomplete="false" value="{{$car->model}}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Matricula</label>
                            <input name="licensePlate" id="licensePlate" type="text" class="form-control"
                                   placeholder="ex: 12.AB.34" required autocomplete="false"
                                   value="{{$car->licensePlate}}"
                                   pattern="[A-Z0-9]{2}\.[A-Z0-9]{2}\.[A-Z0-9]{2}"
                                   onblur="checkLicensePlate()"
                                   onkeyup="this.value = this.value.toUpperCase();">
                            <small id="licensePlateError" class="text-danger d-none">Esta matricula já existe</small>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-custom" id="submitBtn">Atualizar Veiculo
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        function checkLicensePlate() {
            const licensePlateInput = document.getElementById('licensePlate');
            const licensePlateValue = licensePlateInput.value;
            const licensePlateError = document.getElementById('licensePlateError');
            const submitBtn = document.getElementById('submitBtn');
            const carId = {{$car->id}}

            // Make an AJAX request to the server to check if the license plate exists
            axios.post('/tables/checkPlate/edit', {
                licensePlate: licensePlateValue,
                carId
            })
                .then(response => {
                    const exists = response.data.exists;
                    if (exists) {
                        licensePlateError.classList.remove('d-none'); // Show the error message
                        submitBtn.disabled = true;
                        submitBtn.innerText = 'A Verificar...';
                    } else {
                        licensePlateError.classList.add('d-none'); // Hide the error message
                        submitBtn.disabled = false;
                        submitBtn.innerText = 'Atualizar Veiculo';
                    }
                })
                .catch(error => {
                    console.error(error);
                });
        }

        document.addEventListener('DOMContentLoaded', function () {
            const licensePlateInput = document.getElementById('licensePlate');
            const debouncedCheckLicensePlate = debounce(checkLicensePlate, 300);
            licensePlateInput.addEventListener('input', debouncedCheckLicensePlate);

            const carForm = document.getElementById('carForm');
            carForm.addEventListener('submit', function (event) {
                event.preventDefault(); // Prevent the default form submission

                // Perform the license plate check before submitting the form
                checkLicensePlate();

                // Submit the form if the license plate check is successful
                const submitBtn = document.getElementById('submitBtn');
                if (!submitBtn.disabled) {
                    carForm.submit();
                }
            });
        });
    </script>

    <!--Delete car-->
    <div class="modal fade" id="deleteCar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Eliminar Veiculo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form autocomplete="off" id="carForm" method="post"
                          action="{{route('car.delete', $car->id)}}">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputPassword1">Eliminar veiculo numero:{{ $car->id }}</label>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-custom">Eliminar Veiculo</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById("licensePlate").addEventListener("input", function (e) {
            let input = e.target;
            let value = input.value;

            // Remove non-letter and non-number characters from the value
            let sanitizedValue = value.replace(/[^a-zA-Z0-9]/g, '');

            // Truncate the value to a maximum of 8 characters
            sanitizedValue = sanitizedValue.substring(0, 6);

            // Insert dots after each pair of characters
            if (sanitizedValue.length > 2) {
                sanitizedValue = sanitizedValue.match(/.{1,2}/g).join('.');
            }

            input.value = sanitizedValue;
        });
    </script>

@endsection

