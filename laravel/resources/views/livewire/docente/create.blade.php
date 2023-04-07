<div wire:ignore.self id="modalCreate" class="modal fade bd-example-modal-form" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: rgb(135, 228, 123)">
                <h5 class="modal-title" id="exampleModalform">DATOS DE DOCENTE</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="field-1" class="control-label">NOMBRE</label>
                            <input type="text" wire:model.defer="nombres" class="form-control"  required>
                            @error('nombres') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="field-1" class="control-label">APELLIDOS</label>
                            <input type="text" wire:model.defer="apellidos" class="form-control"  required>
                            @error('apellidos') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="field-2" class="control-label">N° DOCUMENTO</label>
                            <input type="number" wire:model.defer="documento" class="form-control"  min="0" step="1">
                            @error('num_doc') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="field-2" class="control-label">CORREO</label>
                            <input type="text" wire:model.defer="correo" class="form-control"  >
                            @error('correo') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="field-2" class="control-label">TELÉFONO</label>
                            <input type="number" wire:model.defer="telefono" class="form-control"  min="0">
                            @error('telefono') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="field-2" class="control-label">ESCALAFÓN</label>
                            <input type="text" wire:model.defer="escalafon" class="form-control"  min="0">
                            @error('escalafon') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                        <div class="form-group">
                            <label for="field-2" class="control-label">ESPECIALIDAD</label>
                            <input type="text" wire:model.defer="especialidad" class="form-control" >

                        </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="field-2" class="control-label">NIVEL</label>
                               <select  class="form-control" wire:model.defer="nivel">
                                   <option value="">SELECCIONE</option>
                                   <option value="PRIMERA INFANCIA">PRIMERA INFANCIA</option>
                                   <option value="PRIMARIA">PRIMARIA</option>
                                   <option value="SECUNDARIA">SECUNDARIA</option>
                               </select>
                                @error('nivel') <span class="text-danger error">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="field-2" class="control-label">TIPO</label>
                               <select  class="form-control" wire:model.defer="tipo">
                                   <option value="">SELECCIONE</option>
                                   <option value="1">DOCENTE</option>
                                   <option value="2">CORDINADOR ACADEMICO</option>
                                   <option value="3">ADMINISTRATIVO</option>
                               </select>
                                @error('tipo') <span class="text-danger error">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="field-2" class="control-label">SEDE</label>
                               <select  class="form-control" wire:model.defer="sede">
                                   <option value="">SELECCIONE</option>
                                  @foreach ($sedes as $item)
                                      <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                                  @endforeach
                               </select>
                                @error('sede') <span class="text-danger error">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                @if($updateMode)
                <button type="button" wire:click.prevent="update" class="btn btn-raised btn-success ml-2"><i class="mdi mdi-content-save-all">
                </i> ACTUALIZAR</button>
                @else
                <button type="button" wire:click.prevent="store" class="btn btn-raised btn-success ml-2"><i class="mdi mdi-content-save-all">
                </i> GUARDAR</button>
                @endif
                <button type="button" class="btn btn-raised btn-danger ml-2" data-dismiss="modal"><i class="mdi mdi-close-octagon
                    "></i> CANCELAR</button>
            </div>
        </div>
    </div>
</div>
