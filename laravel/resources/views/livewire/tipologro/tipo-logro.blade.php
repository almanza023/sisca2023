<div>

    @include('livewire.tipologro.create')
    @include('livewire.tipologro.bloquear')
    @if (session()->has('message'))
    <script>
        success("{{ session('message') }}");
    </script>
    @endif
    @include('livewire.tipologro.tabla')

</div>
