<div wire:ignore.self id="cognitivo" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">LOGROS ACADEMICOS</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
               <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>N°</th>
                            <th>CODIGO</th>
                            <th>DESCRIPCIÓN</th>
                            <th>TIPO</th>
                            <th>PERIODO</th>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($logrosAcademicos as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="bg-info">{{ $item->id }}</td>
                                <td>{{ $item->descripcion }}</td>
                                <td>{{ $item->tipo->nombre }}</td>
                                <td>{{ $item->periodo->numero }}</td>

                            </tr>
                        @empty

                        @endforelse
                    </tbody>
               </table>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-raised btn-danger ml-2" data-dismiss="modal"><i class="mdi mdi-close-octagon
                    "></i> CANCELAR</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



