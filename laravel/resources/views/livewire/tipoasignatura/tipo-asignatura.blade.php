<div>

    @include('livewire.tipoasignatura.create')
    @include('livewire.tipoasignatura.bloquear')
    @if (session()->has('message'))
    <script>
        success("{{ session('message') }}");
    </script>
    @endif
    @include('livewire.tipoasignatura.tabla')

</div>


