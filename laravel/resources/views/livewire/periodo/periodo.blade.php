
    <div>

        @include('livewire.periodo.create')
        @include('livewire.periodo.bloquear')
        @if (session()->has('message'))
        <script>
            success("{{ session('message') }}");
        </script>
        @endif
        @include('livewire.periodo.tabla')

    </div>





