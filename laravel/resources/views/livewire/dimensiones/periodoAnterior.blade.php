<div wire:ignore.self id="periodoAnterior" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">CALIFICACION DE DIMENSION PERIODO ANTERIOR</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
               <table class="table">
                    <thead>
                        <tr>
                            <th>CODIGO</th>
                            <th>DESCRIPCIÓN</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($anteriores as $item =>$value)
                        <tr>
                       <td>
                           {{ $anteriores[$loop->iteration-1]['codigo'] }}
                       </td>
                       <td>
                        {{ $anteriores[$loop->iteration-1]['descripcion'] }}
                    </td>
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
