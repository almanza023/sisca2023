<div>

    <div>

        @include('livewire.docente.create')
        @include('livewire.docente.bloquear')
        @if (session()->has('message'))
        <script>
            success("{{ session('message') }}");
        </script>
        @endif
        @include('livewire.docente.tabla')

</div>

