<div>

    @include('livewire.sede.create')
    @include('livewire.sede.bloquear')
    @if (session()->has('message'))
    <script>
        success("{{ session('message') }}");
    </script>
    @endif
    @include('livewire.sede.tabla')

</div>


