<div>
    <!--SEO-->
    @section('tituloPagina', 'Marcas')

    <!--TITULO-->
    <h1>Marcas</h1>

    <!--FORMULARIOS-->
    <form wire:submit.prevent="crearMarca">
        <!--NOMBRE-->
        <div>
            <p>Nombre: </p>
            <input type="text" wire:model="crearFormulario.nombre">
            @error('crearFormulario.nombre')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <!--SLUG-->
        <div>
            <p>Slug: </p>
            <input type="text" wire:model="crearFormulario.slug">
            @error('crearFormulario.slug')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <!--DESCRIPCIÓN-->
        <div>
            <p>Descripción: </p>
            <input type="text" wire:model="crearFormulario.descripcion">
            @error('crearFormulario.descripcion')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <!--IMAGEN-->
        <div>
            <p>Imagen: </p>
            <div style="width: 100px; height: 100px;">
                @if ($imagen)
                    <img style="width: 100px; height: 100px;" src="{{ $imagen->temporaryUrl() }}">
                @else
                    <img style="width: 100px; height: 100px;" src="{{ asset('imagenes/producto/sin_foto_producto.png') }}">
                @endif
                <label for="imagen">
                    <div>
                        Editar <i class="fa-solid fa-camera"></i>
                    </div>
                </label>
                <div wire:click="$set('imagen', null)">
                    Cancelar <i class="fa-solid fa-trash"></i>
                </div>
            </div>
            <input type="file" wire:model="imagen" style="display: none" id="imagen">
            @error('imagen')
                <span>{{ $message }}</span>
            @enderror
        </div>
        <br>
        <br>
        
        <!--ENVIAR-->
        <div>
            <input type="submit" value="Crear Marca">
        </div>
    </form>


    @if ($marcas->count())
        <!--SUBTITULO-->
        <h1>Lista Marcas</h1>

        <!--TABLA-->
        <table>
            <thead>
                <tr>
                    <th>
                        Imagen</th>
                    <th>
                        Nombre</th>
                    <th>
                        Ruta</th>
                    <th>
                        Descripción</th>
                    <th>
                        Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($marcas as $marcaItem)
                    <tr>
                        <td>
                            <div style="width: 20px; height: 20px;">
                                @if ($marcaItem->imagen)
                                    <img src="{{ Storage::url($marcaItem->imagen->imagen_ruta) }}" alt="" />
                                @else
                                    <img src="{{ asset('imagenes/producto/sin_foto_producto.png') }}">
                                @endif
                            </div>
                        </td>
                        <td>
                            {{ $marcaItem->nombre }}
                        </td>
                        <td>
                            {{ $marcaItem->slug }}
                        </td>
                        <td>
                            {{ Str::limit($marcaItem->descripcion, 20) }}
                        </td>
                        <td>
                            <a wire:click="editarMarca('{{ $marcaItem->slug }}')">
                                <span><i class="fa-solid fa-pencil"></i></span>
                                Editar</a> |
                            <a wire:click="$emit('eliminarMarcaModal', '{{ $marcaItem->slug }}')">
                                <span><i class="fa-solid fa-trash"></i></span>
                                Eliminar</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No hay marcas.</p>
    @endif

    @if ($marca)
        <!--MODAL-->
        <x-jet-dialog-modal wire:model="editarFormulario.abierto">
            <!--TITULO-->
            <x-slot name="title">
                <div>
                    <!--ENCABEZADO-->
                    <div>
                        <h2>Editar</h2>
                    </div>

                    <!--CERRAR-->
                    <div>
                        <button wire:click="$set('editarFormulario.abierto', false)" wire:loading.attr="disabled">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                </div>
            </x-slot>
            <!--CONTENIDO-->
            <x-slot name="content">
                <!--IMAGEN-->
                <div>
                    <p>Imagen: </p>
                    <div style="width: 100px; height: 100px;">
                        @if ($editarImagen)
                            <img style="width: 100px; height: 100px;" src="{{ $editarImagen->temporaryUrl() }}">
                        @elseif($imagen)
                            <img style="width: 100px; height: 100px;"
                                src="{{ Storage::url($marca->imagen->imagen_ruta) }}">
                            <div wire:click="$set('imagen', null)">
                                Eliminar <i class="fa-solid fa-trash"></i>
                            </div>
                        @else
                            <img style="width: 100px; height: 100px;"
                                src="{{ asset('imagenes/producto/sin_foto_producto.png') }}">
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
                <!--NOMBRE-->
                <div>
                    <p>Nombre: </p>
                    <input type="text" wire:model="editarFormulario.nombre">
                    @error('editarFormulario.nombre')
                        <span>{{ $message }}</span>
                    @enderror
                </div>

                <!--SLUG-->
                <div>
                    <p>Slug: </p>
                    <input type="text" wire:model="editarFormulario.slug">
                    @error('editarFormulario.slug')
                        <span>{{ $message }}</span>
                    @enderror
                </div>

                <!--DESCRIPCIÓN-->
                <div>
                    <p>Descripción: </p>
                    <input type="text" wire:model="editarFormulario.descripcion">
                    @error('editarFormulario.descripcion')
                        <span>{{ $message }}</span>
                    @enderror
                </div>

            </x-slot>
            <x-slot name="footer">
                <div class="contenedor_pie_modal">
                    <button wire:click="$set('editarFormulario.abierto', false)" wire:loading.attr="disabled"
                        type="submit">Cancelar</button>

                    <button wire:click="actualizarMarca" wire:loading.attr="disabled" wire:target="actualizarMarca"
                        type="submit">Editar</button>
                </div>
            </x-slot>
        </x-jet-dialog-modal>
    @endif
</div>

<!--SCRIPT-->
@push('script')
    <script>
        Livewire.on('eliminarMarcaModal', marcaId => {
            Swal.fire({
                title: '¿Quieres eliminar?',
                text: "No podrás recuparlo.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '¡Sí, eliminar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emitTo('administrador.marca.marca-livewire',
                        'eliminarMarca', marcaId);
                    Swal.fire(
                        '¡Eliminado!',
                        'Eliminaste correctamente.',
                        'success'
                    );
                }
            })
        });
    </script>
@endpush
