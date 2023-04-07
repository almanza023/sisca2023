<div>

    @include('livewire.usuario.create')
    @include('livewire.usuario.bloquear')
    @if (session()->has('message'))
    <script>
        success("{{ session('message') }}");
    </script>
    @endif

    @if (session()->has('error'))
    <script>
        error("{{ session('error') }}");
    </script>
    @endif
    @include('livewire.usuario.tabla')

</div>
