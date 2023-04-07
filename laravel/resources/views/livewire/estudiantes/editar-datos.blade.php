<div>
    @if (session()->has('message'))
    <script>
        alertify.success("{{ session('message') }}").delay(3000);
    </script>
    @endif
    <br>
    <div class="col-md-12 col-lg-12 col-xl-12">
        <div class="card m-b-30">
            <div class="card-body">
                <h4 class="mt-0 header-title">EDITAR DE INFORMACION ESTUDIANTES</h4>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="field-2" class="control-label"><b>DOCUMENTO</b></label>
                           <input type="number" class="form-control" wire:model="documento">
                            @error('documento') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-md-6">

                        <div class="form-group">
                           <br>
                            <button class="btn btn-outline-info btn-block" wire:click="buscar()"><span class="ai-search"></span>BUSCAR</button>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>

        @if ($visible)
        <div class="col-md-12 col-lg-12 col-xl-12">
            <div class="card m-b-30">
                <div class="card-body">
                    <h4 class="mt-0 header-title">DETALLES DE INFORMACION</h4>
                    <div class="row">
                        <div class="col">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <tr>
                                        <th>NOMBRES</th>
                                        <td>
                                            <input type="text" class="form-control" wire:model.defer='nombres'>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>APELLIDOS</th>
                                        <td>
                                            <input type="text" class="form-control" wire:model.defer='apellidos'>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>DOCUMENTO</th>
                                        <td>
                                            <input type="number" class="form-control" wire:model.defer='num_doc'>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>FOLIO</th>
                                        <td>
                                            <input type="text" class="form-control" wire:model.defer='folio'>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                   <br>
                                    <button class="btn btn-outline-primary btn-block" wire:click="update()"><span class="ai-search"></span>ACTUALIZAR</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                </div>
            </div>
        @endif

</div>
