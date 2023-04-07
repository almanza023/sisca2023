
  <div class="row m-t-30">
    <div class="col-md-12 col-lg-12 col-xl-12">
        <div class="card m-b-30">
            <div class="card-body">
                <h4 class="mt-0 header-title"> APERTURA DE PERIODOS</h4>
                <button type="button" class="btn btn-raised btn-primary m-t-10 m-b-10" data-toggle="modal" data-target=".bd-example-modal-form">
                    <i class="typcn typcn-document-add"> </i>CREAR</button>
                    <div class="w-full flex pb-10">
                        <div class="w-3/6 mx-1">
                            <input wire:model.debounce.300ms="search" type="text" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"placeholder="Buscar">
                        </div>


                    </div>
                    <table class="table mb-0" id="datatable2">
                        <thead>
                            <tr>
                                <th>PERIODO</th>
                                <th>FECHA APERTURA</th>
                                <th>FECHA CIERRE</th>
                                <th>ESTADO</th>
                                <th>ACIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $item)
                            <tr>
                                <td>{{ $item->periodo->descripcion }}</td>
                                <td>{{ $item->fecha_apertura }}</td>
                                <td>{{ $item->fecha_cierre }}</td>
                                <td>
                                    @if($item->estado==1)
                                    <button data-toggle="modal" data-animation="bounce" wire:click="editEstado({{ $item->id }})" data-target=".bs-example-modal-center"  class="btn btn-outline-success btn-sm"><i class="typcn typcn-delete-outline"></i>ACTIVO</button>
                                    @else
                                    <button data-toggle="modal" data-animation="bounce" wire:click="editEstado({{ $item->id }})" data-target=".bs-example-modal-center"  class="btn btn-outline-danger btn-sm"><i class="typcn typcn-delete-outline"></i>BLOQUEADO</button>

                                    @endif
                                </td>
                                <td>
                                    <button data-toggle="modal" data-target="#modalCreate" wire:click="edit({{ $item->id }})" class="btn btn-outline-info btn-sm"><i class="typcn typcn-edit"></i></button>
                                </td>
                            </tr>

                            @empty
                                <tr>
                                    <td colspan="4"><center>No Existen datos</center></td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                    {!! $data->links() !!}

            </div>
        </div>
    </div>
</div>
