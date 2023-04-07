<div>

    @include('livewire.asignatura.create')
    @include('livewire.asignatura.bloquear')
    @if (session()->has('message'))
    <script>
        success("{{ session('message') }}");
    </script>
    @endif
    @include('livewire.asignatura.tabla')
</div>

