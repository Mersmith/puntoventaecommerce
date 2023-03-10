<div>
    <!--SEO-->
    @section('tituloPagina', 'PERFIL')

    <!--TITULO-->
    <h1>PERFIL</h1>

    <!--FORMULARIO-->
    <div x-data>
        <!--EMAIL-->
        <div>
            <p>Email: </p>
            <input type="email" wire:model="email" disabled>
            @error('email')
                <span>{{ $message }}</span>
            @enderror
        </div>    

        <!--NOMBRE-->
        <div>
            <p>Nombre: </p>
            <input type="text" wire:model="nombre">
            @error('nombre')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <!--APELLIDO-->
        <div>
            <p>Apellido: </p>
            <input type="text" wire:model="apellido">
            @error('apellido')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <!--CELULAR-->
        <div>
            <p>Celular: </p>
            <input type="tel" wire:model="celular">
            @error('celular')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <!--IMAGEN-->
        <div>
            <p>Imagen: </p>
            <div style="width: 100px; height: 100px;">
                @if ($editarImagen)
                    <img style="width: 100px; height: 100px;" src="{{ $editarImagen->temporaryUrl() }}">
                @elseif($imagen)
                    <img style="width: 100px; height: 100px;" src="{{ Storage::url($administrador->imagen->imagen_ruta) }}">
                    <div wire:click="$set('imagen', null)">
                        Eliminar <i class="fa-solid fa-trash"></i>
                    </div>
                @else
                    <img style="width: 100px; height: 100px;" src="{{ asset('imagenes/perfil/sin_foto_perfil.png') }}">
                @endif
                <label for="imagen">
                    <div>
                        Editar <i class="fa-solid fa-camera"></i>
                    </div>
                </label>
                <div wire:click="$set('editarImagen', null)">
                    Cancelar <i class="fa-solid fa-trash"></i>
                </div>
            </div>
            <input type="file" wire:model="editarImagen" style="display: none" id="imagen">
            @error('editarImagen')
                <span>{{ $message }}</span>
            @enderror
        </div>
        <br>
        <br>
        <br>
        <br>

        <!--ENVIAR-->
        <div>
            <button wire:loading.attr="disabled" wire:target="editarAdministrador" wire:click="editarAdministrador">
                Actualizar administrador
            </button>
        </div>
    </div>
</div>

@push('script')
    <script>
        Livewire.on('eliminarAdministradorModal', () => {
            Swal.fire({
                title: '??Quieres eliminar?',
                text: "No podr??s recuparlo.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '??S??, eliminar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emitTo('administrador.perfil.perfil-livewire',
                        'eliminarAdministador');
                    Swal.fire(
                        '??Eliminado!',
                        'Eliminaste correctamente.',
                        'success'
                    )
                }
            })
        })
    </script>
@endpush
