
  <div class="row m-t-30">
    <div class="col-md-12 col-lg-12 col-xl-12">
        <div class="card m-b-30">
            <div class="card-body">
                <h4 class="mt-0 header-title"> SEDES</h4>
                <button type="button" class="btn btn-raised btn-primary m-t-10 m-b-10" data-toggle="modal" data-target=".bd-example-modal-form">
                    <i class="typcn typcn-document-add"> </i>CREAR</button>
                    <div class="w-full flex pb-10">
                        <div class="w-3/6 mx-1">
                            <input wire:model.debounce.300ms="search" type="text" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"placeholder="Buscar">
                        </div>
                        <div class="w-1/6 relative mx-1">
                            <select wire:model="orderBy" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-state">
                                <option value="id">ID</option>
                                <option value="numero">NÚMERO</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                            </div>
                        </div>
                        <div class="w-1/6 relative mx-1">
                            <select wire:model="orderAsc" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-state">
                                <option value="1">Ascendente</option>
                                <option value="0">Descendete</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                            </div>
                        </div>
                        <div class="w-1/6 relative mx-1">
                            <select wire:model="perPage" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-state">
                                <option>2</option>
                                <option>25</option>
                                <option>50</option>
                                <option>100</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                            </div>
                        </div>
                    </div>
                    <table class="table mb-0" id="datatable2">
                        <thead>
                            <tr>
                                <th>DESCRIPCION</th>
                                <th>NUMERO</th>
                                <th>PORCENTAJE</th>
                                <th>ESTADO</th>
                                <th>ACIONES</th>
                            </tr>
                        </thead>
                        @php
                            $suma=0;
                        @endphp
                        <tbody>
                            @forelse ($data as $periodo)
                            @php
                                $suma+=$periodo->porcentaje;
                            @endphp
                            <tr>
                                <td>{{ $periodo->descripcion }}</td>
                                <td>{{ $periodo->numero }}</td>
                                <td>{{ $periodo->porcentaje }}%</td>
                                <td>
                                    @if($periodo->estado==1)
                                    <button data-toggle="modal" data-animation="bounce" wire:click="editEstado({{ $periodo->id }})" data-target=".bs-example-modal-center"  class="btn btn-outline-success btn-sm"><i class="typcn typcn-delete-outline"></i>ACTIVO</button>
                                    @else
                                    <button data-toggle="modal" data-animation="bounce" wire:click="editEstado({{ $periodo->id }})" data-target=".bs-example-modal-center"  class="btn btn-outline-danger btn-sm"><i class="typcn typcn-delete-outline"></i>BLOQUEADO</button>

                                    @endif
                                </td>
                                <td>
                                    <button data-toggle="modal" data-target="#modalCreate" wire:click="edit({{ $periodo->id }})" class="btn btn-outline-info btn-sm"><i class="typcn typcn-edit"></i></button>
                                </td>
                            </tr>

                            @empty
                                <tr>
                                    <td colspan="4"><center>No Existen datos</center></td>
                                </tr>
                            @endforelse
                            <tr>
                                <th colspan="2">
                                    TOTAL
                                </th>
                                <td>
                                    {{ $suma }}%
                                </td>
                            </tr>
                        </tbody>

                    </table>
                    {!! $data->links() !!}

            </div>
        </div>
    </div>
</div>
