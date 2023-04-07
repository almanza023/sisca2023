<div>
    @if (session()->has('message'))
    <script>
        alertify.success("{{ session('message') }}").delay(3000);
    </script>
    @endif
    <div class="row m-t-30">
        <div class="col-md-12 col-lg-12 col-xl-12">
            <div class="card m-b-30">
                <div class="card-body">
                    <h4 class="mt-0 header-title">DATOS ESTUDIANTE</h4>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="field-1" class="control-label">NOMBRES</label>
                                <input type="text" wire:model="nombres" class="form-control"  required>
                                @error('nombres') <span class="text-danger error">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="field-1" class="control-label">APELLIDOS</label>
                                <input type="text" wire:model.defer="apellidos" class="form-control"  required>
                                @error('apellidos') <span class="text-danger error">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="field-1" class="control-label">TIPO DOCUMENTO</label>
                               <select class="form-control" wire:model.defer="tipo_doc">
                                   <option value="">SELECIONE</option>
                                   <option value="RC">RC</option>
                                   <option value="TI">TI</option>
                                   <option value="CC">CC</option>
                                   <option value="PEP">PEP</option>
                                   <option value="OTRO">OTRO</option>
                               </select>
                                @error('tipo_doc') <span class="text-danger error">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="field-1" class="control-label">N° DOCUMENTO</label>
                                <input type="text" wire:model.defer="num_doc" class="form-control"  required>
                                @error('num_doc') <span class="text-danger error">{{ $message }}</span>@enderror
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="field-1" class="control-label">FECHA NACIMIENTO</label>
                                <input type="date" wire:model.defer="fecha_nac" class="form-control"  >
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="field-1" class="control-label">LUGAR DE NACIMIENTO</label>
                                <input type="text" wire:model.defer="lugar_nac" class="form-control"  >
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="field-1" class="control-label">ESTRATO</label>
                                <input type="number" wire:model.defer="estrato" class="form-control"  >
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="field-1" class="control-label">DIRECCIÓN</label>
                                <input type="text" wire:model.defer="direccion" class="form-control"  >
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="field-1" class="control-label">EPS</label>
                                <input type="text" wire:model.defer="eps" class="form-control"  >
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="field-1" class="control-label">ZONA</label>
                                <select class="form-control" wire:model.defer="zona">
                                    <option value="">SELECIONE</option>
                                    <option value="RURAL">RURAL</option>
                                    <option value="URBANA">URBANA</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="field-1" class="control-label">TIPO SANGRE</label>
                                <select class="form-control" wire:model.defer="tipo_sangre">
                                    <option value="">SELECIONE</option>
                                    <option value="O+">O+</option>
                                    <option value="A+">A+</option>
                                    <option value="A-">A-</option>
                                    <option value="B-">B-</option>
                                    <option value="B+">B+</option>
                                    <option value="AB+">AB+</option>
                                    <option value="AB-">AB-</option>

                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="field-1" class="control-label">DESPLAZADO</label>
                                <select class="form-control" wire:model.defer="desplazado">
                                    <option value="">SELECIONE</option>
                                    <option value="SI">SI</option>
                                    <option value="NO">NO</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="field-1" class="control-label">NOMBRE MADRE</label>
                                <input type="text" wire:model.defer="nombre_madre" class="form-control"  >
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="field-1" class="control-label">NOMBRE PADRE</label>
                                <input type="text" wire:model.defer="nombre_padre" class="form-control"  >
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="field-1" class="control-label">NOMBRE ACUDIENTE</label>
                                <input type="text" wire:model.defer="nombre_acudiente" class="form-control"  >
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="field-1" class="control-label">TELEFONO ACUDIENTE</label>
                                <input type="number" wire:model.defer="telefono_acudiente" class="form-control"  >
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-12 col-xl-12">
            <div class="card m-b-30">
                <div class="card-body">
                    <h4 class="mt-0 header-title">DATOS ACADEMICOS</h4>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="field-2" class="control-label">GRADO</label>
                               <select  class="form-control" wire:model.defer="grado">
                                   <option value="">SELECCIONE</option>
                                  @foreach ($grados as $item)
                                      <option value="{{ $item->id }}">{{ $item->descripcion }}</option>
                                  @endforeach
                               </select>
                                @error('sede') <span class="text-danger error">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-md-3">
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
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="field-1" class="control-label">NIVEL</label>
                               <select class="form-control" wire:model.defer="nivel">
                                   <option value="">SELECIONE</option>
                                   <option value="PREESCOLAR">PREESCOLAR</option>
                                   <option value="PIRMARIA">PIRMARIA</option>
                                   <option value="SECUNDARIA">SECUNDARIA</option>
                                   <option value="MEDIA ACADEMICA">MEDIA ACADEMICA</option>
                               </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="field-1" class="control-label">FOLIO</label>
                                <input type="text" wire:model.defer="folio" class="form-control"  required>
                                @error('folio') <span class="text-danger error">{{ $message }}</span>@enderror
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="field-1" class="control-label">REPITENTE</label>
                                <select class="form-control" wire:model.defer="repitente">
                                    <option value="">SELECIONE</option>
                                    <option value="SI">SI</option>
                                    <option value="NO">NO</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                            <button type="button" wire:click="store" class="btn btn-raised btn-success ml-2"><i class="mdi mdi-content-save-all">
                            </i> GUARDAR</button>
                            </div>
                        </div>
                    </div>



                </div>
            </div>
        </div>
    </div>
</div>

