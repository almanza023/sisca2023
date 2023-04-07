<div>

    @include('livewire.direcciongrados.create')
    @include('livewire.direcciongrados.bloquear')
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
    @include('livewire.direcciongrados.tabla')

</div>
