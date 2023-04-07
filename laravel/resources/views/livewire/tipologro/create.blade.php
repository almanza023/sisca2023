<div wire:ignore.self id="modalCreate" class="modal fade bd-example-modal-form" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: rgb(135, 228, 123)">
                <h5 class="modal-title" id="exampleModalform">DATOS TIPO DE LOGRO</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="field-1" class="control-label">Nombre</label>
                            <input type="text" wire:model="nombre" class="form-control"  required>
                            @error('nombre') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="field-1" class="control-label">Nivel</label>
                            <select class="form-control" wire:model="nivel">
                                <option value="">SELECCIONE</option>
                                <option value="DIMENSIONAL">DIMENSIONAL</option>
                                <option value="ACADEMICO">ACADEMICO</option>
                                <option value="COMPORTAMENTAL">COMPORTAMENTAL</option>
                            </select>
                            @error('nombre') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>
                    </div>

                </div>

            </div>
            <div class="modal-footer">
                @if($updateMode)
                <button type="button" wire:click="update" class="btn btn-raised btn-success ml-2"><i class="mdi mdi-content-save-all">
                </i> ACTUALIZAR</button>
                @else
                <button type="button" wire:click="store" class="btn btn-raised btn-success ml-2"><i class="mdi mdi-content-save-all">
                </i> GUARDAR</button>
                @endif
                <button type="button" class="btn btn-raised btn-danger ml-2" data-dismiss="modal"><i class="mdi mdi-close-octagon
                    "></i> CANCELAR</button>
            </div>
        </div>
    </div>
</div>
