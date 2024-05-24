@extends('adminlte::page')

@section('content')

    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

    <div class="container pt-4">
        <a class="btn btn-custom btn-block mb-3" data-toggle="modal"
           data-target="#createCar">Registar Novo Veiculo</a>
        <h1>Veiculos Registados</h1>
        <table class="table table-bordered">
            <thead>
            <tr class="text-center">
                <th>ID</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Matrícula</th>
                <th>Data de Criação</th>
                <th>Opções</th>
            </tr>
            </thead>
            <tbody>
            <!-- Loop through the cars and generate a row for each one -->
            @foreach ($cars as $car)
                <tr class="text-center">
                    <td>{{ $car->id }}</td>
                    <td>{{ $car->brand }}</td>
                    <td>{{ $car->model }}</td>
                    <td>{{ $car->licensePlate }}</td>
                    <td>{{ date('d/m/Y', strtotime($car->created_at)) }}</td>
                    <td>
                        <div class="d-flex justify-content-around">
                            @if(!$car->interventions || count($car->interventions) === 0)
                                <a
                                    class="btn btn-outline-success btn-icon animated-hover"
                                    data-toggle="modal" data-target="#editCar-{{ $car->id }}"
                                    data-placement="top" title="Editar Intervenção">
                                    <i class="far fa-edit"></i>
                                </a>
                                <a
                                    class="btn btn-outline-warning btn-icon animated-hover"
                                    data-placement="top" title="Eliminar Intervenção"
                                    data-toggle="modal" data-target="#deleteCar-{{$car->id}}">
                                    <i class="far fa-trash-alt"></i>
                                </a>

                                <!--Edit Cars-->
                                <div class="modal fade" id="editCar-{{ $car->id }}" tabindex="-1" role="dialog"
                                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Atualizar Veiculo
                                                    nº {{ $car->id }}</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form autocomplete="off" id="carForm-{{$car->id}}" method="post"
                                                      action="{{route('car.update', $car->id)}}">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label for="exampleInputPassword1">Marca</label>
                                                        <input name="brand" type="text" class="form-control"
                                                               placeholder="ex: Renault" required autocomplete="false"
                                                               value="{{ $car->brand }}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInputPassword1">Modelo</label>
                                                        <input name="model" type="text" class="form-control"
                                                               placeholder="ex: Clio" required autocomplete="false"
                                                               value="{{ $car->model }}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInputPassword1">Matricula</label>
                                                        <input name="licensePlate" id="licensePlate-{{ $car->id }}"
                                                               type="text" class="form-control"
                                                               placeholder="ex: 12.AB.34" required autocomplete="false"
                                                               onblur="checkLicensePlate{{ $car->id }}()"
                                                               pattern="[A-Z0-9]{2}\.[A-Z0-9]{2}\.[A-Z0-9]{2}"
                                                               onkeyup="this.value = this.value.toUpperCase();"
                                                               value="{{ $car->licensePlate }}">
                                                        <small id="licensePlateError-{{ $car->id }}"
                                                               class="text-danger d-none">Esta matricula já
                                                            existe</small>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Fechar
                                                        </button>
                                                        <button type="submit" class="btn btn-custom"
                                                                id="submitBtn-{{ $car->id }}">Registar Veiculo
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <script>
                                    function debounce(func, delay) {
                                        let timeoutId;
                                        return function () {
                                            const context = this;
                                            const args = arguments;
                                            clearTimeout(timeoutId);
                                            timeoutId = setTimeout(function () {
                                                func.apply(context, args);
                                            }, delay);
                                        };
                                    }

                                    function checkLicensePlate{{ $car->id }}() {
                                        const licensePlateInput = document.getElementById('licensePlate-{{ $car->id }}');
                                        const licensePlateValue = licensePlateInput.value;
                                        const licensePlateError = document.getElementById('licensePlateError-{{ $car->id }}');
                                        const submitBtn = document.getElementById('submitBtn-{{ $car->id }}');
                                        const carId = {{ $car->id }};

                                        // Make an AJAX request to the server to check if the license plate exists
                                        submitBtn.disabled = true;
                                        submitBtn.innerText = 'A Verificar...';

                                        axios.post('/tables/checkPlate/edit', {
                                            licensePlate: licensePlateValue,
                                            carId
                                        })
                                            .then(response => {
                                                const exists = response.data.exists;
                                                if (exists) {
                                                    licensePlateError.classList.remove('d-none'); // Show the error message
                                                    submitBtn.disabled = true;
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
                                        const licensePlateInput{{ $car->id }} = document.getElementById('licensePlate-{{ $car->id }}');
                                        const debouncedCheckLicensePlate{{ $car->id }} = debounce(checkLicensePlate{{ $car->id }}, 300);
                                        licensePlateInput{{ $car->id }}.addEventListener('input', debouncedCheckLicensePlate{{ $car->id }});

                                        const carForm{{ $car->id }} = document.getElementById('carForm-{{ $car->id }}');
                                        carForm{{ $car->id }}.addEventListener('submit', function (event) {
                                            event.preventDefault(); // Prevent the default form submission

                                            // Perform the license plate check before submitting the form
                                            checkLicensePlate{{ $car->id }}();

                                            // Modify the submit button's innerText property during the form submission process
                                            const submitBtn{{ $car->id }} = document.getElementById('submitBtn-{{ $car->id }}');
                                            submitBtn{{ $car->id }}.disabled = true;
                                            submitBtn{{ $car->id }}.innerText = 'A Aguardar...';

                                            // Submit the form after a small delay to allow the innerText change to take effect
                                            setTimeout(function () {
                                                carForm{{ $car->id }}.submit();
                                            }, 200);
                                        });
                                    });
                                </script>

                                <!--Delete car-->
                                <div class="modal fade" id="deleteCar-{{$car->id}}" tabindex="-1" role="dialog"
                                     aria-labelledby="exampleModalLabel"
                                     aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Eliminar Veiculo</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form autocomplete="off" id="carForm" method="post"
                                                      action="{{route('car.delete', $car->id)}}">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label for="exampleInputPassword1">Eliminar veiculo
                                                            numero:{{ $car->id }}</label>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Fechar
                                                        </button>
                                                        <button type="submit" class="btn btn-custom">Eliminar Veiculo
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <script>
                                    document.getElementById("licensePlate-{{$car->id}}").addEventListener("input", function (e) {
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

                            @else
                                <a style="pointer-events: none;"
                                   class="btn btn-outline-secondary btn-icon animated-hover"
                                   data-placement="top" title="Editar Intervenção">
                                    <i class="far fa-edit"></i>
                                </a>
                                <a style="pointer-events: none;"
                                   class="btn btn-outline-secondary btn-icon animated-hover"
                                   data-placement="top" title="Eliminar Intervenção">
                                    <i class="far fa-trash-alt"></i>
                                </a>
                            @endif
                            <a href="{{ route('car.view', $car->id) }}"
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

    @if ($cars->hasPages())
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

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <!--Create Car-->
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
                                   placeholder="ex: 12.AB.34" required autocomplete="false"
                                   pattern="[A-Z0-9]{2}\.[A-Z0-9]{2}\.[A-Z0-9]{2}" onblur="checkGlobalLicensePlate()"
                                   onkeyup="this.value = this.value.toUpperCase();">
                            <small id="licensePlateError" class="text-danger d-none">Esta matricula já existe</small>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-custom" id="submitBtn">Registar Veiculo</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function debounce(func, delay) {
            let timeoutId;
            return function () {
                const context = this;
                const args = arguments;
                clearTimeout(timeoutId);
                timeoutId = setTimeout(function () {
                    func.apply(context, args);
                }, delay);
            };
        }

        function checkGlobalLicensePlate() {
            const licenseGlobalPlateInput = document.getElementById('licensePlate');
            const licenseGlobalPlateValue = licenseGlobalPlateInput.value;
            const licenseGlobalPlateError = document.getElementById('licensePlateError');
            const submitGlobalBtn = document.getElementById('submitBtn');

            // Make an AJAX request to the server to check if the license plate exists
            axios.post('/tables/checkPlate', {
                licensePlate: licenseGlobalPlateValue,
            })
                .then(response => {
                    const exists = response.data.exists;
                    if (exists) {
                        licenseGlobalPlateError.classList.remove('d-none'); // Show the error message
                        submitGlobalBtn.disabled = true;
                        submitGlobalBtn.innerText = 'A Verificar...';
                    } else {
                        licenseGlobalPlateError.classList.add('d-none'); // Hide the error message
                        submitGlobalBtn.disabled = false;
                        submitGlobalBtn.innerText = 'Registar Veiculo';
                    }
                })
                .catch(error => {
                    console.error(error);
                });
        }

        document.addEventListener('DOMContentLoaded', function () {
            const licenseGlobalPlateInput = document.getElementById('licensePlate');
            const debouncedCheckGlobalLicensePlate = debounce(checkGlobalLicensePlate, 300);
            licenseGlobalPlateInput.addEventListener('input', debouncedCheckGlobalLicensePlate);

            const carForm = document.getElementById('carForm');
            carForm.addEventListener('submit', function (event) {
                event.preventDefault(); // Prevent the default form submission

                // Perform the license plate check before submitting the form
                checkGlobalLicensePlate();

                // Submit the form if the license plate check is successful
                const submitGlobalBtn = document.getElementById('submitBtn');
                if (!submitGlobalBtn.disabled) {
                    carForm.submit();
                }
            });
        });
    </script>

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
