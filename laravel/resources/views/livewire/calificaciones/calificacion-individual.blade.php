<div>
    @if (session()->get('error'))
    <script>
        advertencia("{{ session('error') }}");
    </script>
    @endif
    <div class="row">
        <div class="col-md-12 col-lg-12 col-xl-12">
            <div class="card m-b-30">
                <div class="card-body">
                    <h4 class="mt-0 header-title">CONSULTA DE INFORMACION</h4>
                    <div class="row">


        @if(!empty($asignaturas))

        <div class="col-md-12 col-lg-12 col-xl-12" >
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('individual.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="matricula" value="{{ $matricula }}">

                    <table class="table mb-0" id="datatable2">
                        <thead>
                            <tr>
                                <th>ESTUDIANTE</th>
                                <td>{{ $matricula->estudiante->nombres.' '.$matricula->estudiante->apellidos }}</td>
                            </tr>
                            <tr>
                                <th>PERIODO</th>
                                <td>
                                    <select class="form-control" name="periodo" required>
                                        <option value="">Seleccione</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>AREA/ASIGNATURA</th>
                                <th>NOTA</th>
                                <td></td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($asignaturas as $item)
                            <input type="hidden" name="asignaturas[]" value="{{ $item->id }}">
                                <tr>
                                    <td>{{ $item->asignatura->nombre.'  '.$item->porcentaje.'%' }}</td>
                                    <td>
                                        <input type="number" class="form-control" min="1.0" max="5.0" step="0.1" required name="notas[]">
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="2">
                                    <button type="submit" class="btn btn-success btn-block">GUARDAR</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    </form>
            </form>

            </div>

            </div>
            </div>
        </div>
        @endif
    </div>

