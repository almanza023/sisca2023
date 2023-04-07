<div>
    @if (session()->has('message'))
    <script>
        mensaje("{{ session('message') }}");
    </script>
    @endif
    @if (session()->has('error'))
    <script>
        advertencia("{{ session('error') }}");
    </script>
    @endif
    <div class="row">
        @include('filtros.filtro')
    </div>

    @if(count($calificaciones)>0)
    <livewire:nivelaciones.detalles-nivelacion :post="$calificaciones" >
    @endif
</div>
