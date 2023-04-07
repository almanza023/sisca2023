<div>

    @if (session()->has('message'))
    <script>
        success("{{ session('message') }}");
    </script>
    @endif
    @include('livewire.matricula.tabla')

</div>
