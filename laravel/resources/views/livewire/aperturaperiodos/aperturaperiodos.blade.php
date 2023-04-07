
    <div>

        @include('livewire.aperturaperiodos.create')
        @include('livewire.aperturaperiodos.bloquear')
        @if (session()->has('message'))
        <script>
            mensaje("{{ session('message') }}");
        </script>
        @endif
        @include('livewire.aperturaperiodos.tabla')

    </div>





