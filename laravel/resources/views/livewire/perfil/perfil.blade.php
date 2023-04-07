<div>
    @if (session()->has('message'))
    <script>
        mensaje("{{ session('message') }}");
    </script>
    @endif
    @if (session()->has('error'))
    <script>
        advertencia("{{ session('error') }}");
    </script>
    @endif
    <div class="row m-t-10">
        <div class="col-12">
            <div class="card m-t-30">
                <div class="card-body">
                    <h4 class="mt-0 header-title">MIS DATOS</h4>
                    <div class="form-group row">
                        <label for="example-text-input" class="col-sm-2 col-form-label">{{ $name }}</label>

                    </div>

                    <div class="form-group row">
                        <label for="example-search-input" class="col-sm-2 col-form-label">CONTRASEÑA</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="password" wire:model="password1">
                            @error('password1') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-email-input" class="col-sm-2 col-form-label">CONFIRMAR CONTRASEÑA</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="password" wire:model="password2">
                            @error('password2') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="form-group row">
                       <button type="button" wire:click.prevent="update()" class="btn btn-success btn-block">ACTUALIZAR</button>
                    </div>

                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->

</div>
