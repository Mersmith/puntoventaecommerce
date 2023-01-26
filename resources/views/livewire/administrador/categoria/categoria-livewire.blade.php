<div>
    <!--SEO-->
    @section('tituloPagina', 'Categorias')

    <!--TITULO-->
    <h1>Categorias</h1>

    <!--FORMULARIOS-->
    <form wire:submit.prevent="crearCategoria">
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

        <!--MARCAS-->
        <div>
            <p>Marcas: </p>
            @if ($marcas->count())
                <div>
                    @foreach ($marcas as $marca)
                        <label>
                            <input type="checkbox" name="marcas[]" wire:model.defer="crearFormulario.marcas"
                                value="{{ $marca->id }}">
                            <span> {{ $marca->nombre }}</span>
                        </label>
                    @endforeach
                </div>
                @error('crearFormulario.marcas')
                    <span>{{ $message }}</span>
                @enderror
            @endif
        </div>

        <!--IMAGEN-->
        <div>
            <p>Imagen: </p>
            <div style="width: 100px; height: 100px;">
                @if ($imagen)
                    <img style="width: 100px; height: 100px;" src="{{ $imagen->temporaryUrl() }}">
                @else
                    <img style="width: 100px; height: 100px;"
                        src="{{ asset('imagenes/producto/sin_foto_producto.png') }}">
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
            <input type="submit" value="Crear Categoria">
        </div>
    </form>


    @if ($categorias->count())
        <!--SUBTITULO-->
        <h1>Lista Categorias</h1>

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
                @foreach ($categorias as $categoriaItem)
                    <tr>
                        <td>
                            <div style="width: 20px; height: 20px;">
                                @if ($categoriaItem->imagen)
                                    <img src="{{ Storage::url($categoriaItem->imagen->imagen_ruta) }}" alt="" />
                                @else
                                    <img src="{{ asset('imagenes/producto/sin_foto_producto.png') }}">
                                @endif
                            </div>
                        </td>
                        <td>

                            {{ $categoriaItem->nombre }}
                        </td>
                        <td>
                            {{ $categoriaItem->slug }}
                        </td>
                        <td>
                            {{ Str::limit($categoriaItem->descripcion, 20) }}
                        </td>
                        <td>
                            <a href="{{ route('administrador.subcategoria.index', $categoriaItem) }}">
                                <span><i class="fa-solid fa-eye" style="color: #009eff;"></i></span>
                                Ver
                            </a>
                            <a wire:click="editarCategoria('{{ $categoriaItem->slug }}')">
                                <span><i class="fa-solid fa-pencil"></i></span>
                                Editar</a> |
                            <a wire:click="$emit('eliminarCategoriaModal', '{{ $categoriaItem->slug }}')">
                                <span><i class="fa-solid fa-trash"></i></span>
                                Eliminar</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No hay categorias.</p>
    @endif

    @if ($categoria)
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
                                src="{{ Storage::url($categoria->imagen->imagen_ruta) }}">
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

                <!--MARCAS-->
                <div>
                    <p>Marcas: </p>
                    @if ($marcas->count())
                        <div>
                            @foreach ($marcas as $marca)
                                <label>
                                    <input type="checkbox" name="marcas[]" wire:model.defer="editarFormulario.marcas"
                                        value="{{ $marca->id }}">
                                    <span> {{ $marca->nombre }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error('editarFormulario.marcas')
                            <span>{{ $message }}</span>
                        @enderror
                    @endif
                </div>

            </x-slot>
            <x-slot name="footer">
                <div class="contenedor_pie_modal">
                    <button wire:click="$set('editarFormulario.abierto', false)" wire:loading.attr="disabled"
                        type="submit">Cancelar</button>

                    <button wire:click="actualizarCategoria" wire:loading.attr="disabled"
                        wire:target="actualizarCategoria" type="submit">Editar</button>
                </div>
            </x-slot>
        </x-jet-dialog-modal>
    @endif
</div>

<!--SCRIPT-->
@push('script')
    <script>
        Livewire.on('eliminarCategoriaModal', categoriaId => {
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
                    Livewire.emitTo('administrador.categoria.categoria-livewire',
                        'eliminarCategoria', categoriaId);
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
