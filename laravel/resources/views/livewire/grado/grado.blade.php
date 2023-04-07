    <div>

            @include('livewire.grado.create')
            @include('livewire.grado.bloquear')
            @if (session()->has('message'))
            <script>
                success("{{ session('message') }}");
            </script>
            @endif
            @include('livewire.grado.tabla')

    </div>
