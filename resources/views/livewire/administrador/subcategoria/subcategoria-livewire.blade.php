<div>
    <!--SEO-->
    @section('tituloPagina', 'Subcategorias')

    <!--TITULO-->
    <h1>Subcategorias</h1>

    <!--FORMULARIOS-->
    <form wire:submit.prevent="crearSubcategoria">
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

        <!--ICONO-->
        <div>
            <p>Icono: </p>
            <code>
                <?php print htmlentities('<i class="fa-brands fa-facebook"></i>'); ?>
            </code>
            <br>
            <input type="text" wire:model="crearFormulario.icono">
            @error('crearFormulario.icono')
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

        <!--COLOR-->
        <div>
            <p>¿Tiene color?:</p>
            <div>
                <label>
                    <input type="radio" value="1" name="tiene_color"
                        wire:model.defer="crearFormulario.tiene_color">
                    Si
                </label>
                <label>
                    <input type="radio" value="0" name="tiene_color"
                        wire:model.defer="crearFormulario.tiene_color">
                    No
                </label>
            </div>
            @error('crearFormulario.tiene_color')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <!--MEDIDA-->
        <div>
            <p>¿Tiene color?:</p>
            <div>
                <label>
                    <input type="radio" value="1" name="tiene_medida"
                        wire:model.defer="crearFormulario.tiene_medida">
                    Si
                </label>
                <label>
                    <input type="radio" value="0" name="tiene_medida"
                        wire:model.defer="crearFormulario.tiene_medida">
                    No
                </label>
            </div>
            @error('crearFormulario.tiene_medida')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <!--ENVIAR-->
        <div>
            <input type="submit" value="Crear Subcategoria">
        </div>
    </form>


    @if ($subcategorias->count())
        <!--SUBTITULO-->
        <h1>Lista subcategorias</h1>

        <!--TABLA-->
        <table>
            <thead>
                <tr>
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
                @foreach ($subcategorias as $subcategoriaItem)
                    <tr>
                        <td>

                            {{ $subcategoriaItem->nombre }}
                        </td>
                        <td>
                            {{ $subcategoriaItem->slug }}
                        </td>
                        <td>
                            {{ Str::limit($subcategoriaItem->descripcion, 20) }}
                        </td>
                        <td>
                            <a wire:click="editarSubcategoria('{{ $subcategoriaItem->slug }}')">
                                <span><i class="fa-solid fa-pencil"></i></span>
                                Editar</a> |
                            <a wire:click="$emit('eliminarSubcategoriaModal', '{{ $subcategoriaItem->slug }}')">
                                <span><i class="fa-solid fa-trash"></i></span>
                                Eliminar</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No hay subcategorias.</p>
    @endif

    @if ($subcategoria)
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

                <!--ICONO-->
                <div>
                    <p>Icono: </p>
                    <code>
                        <?php print htmlentities('<i class="fa-brands fa-facebook"></i>'); ?>
                    </code>
                    <br>
                    <input type="text" wire:model="editarFormulario.icono">
                    @error('editarFormulario.icono')
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

                <!--COLOR-->
                <div>
                    <p>¿Tiene color?:</p>
                    <div>
                        <label>
                            <input type="radio" value="1" name="editarFormulario.tiene_color"
                                wire:model.defer="editarFormulario.tiene_color">
                            Si
                        </label>
                        <label>
                            <input type="radio" value="0" name="editarFormulario.tiene_color"
                                wire:model.defer="editarFormulario.tiene_color">
                            No
                        </label>
                    </div>
                    @error('editarFormulario.tiene_color')
                        <span>{{ $message }}</span>
                    @enderror
                </div>

                <!--MEDIDA-->
                <div>
                    <p>¿Tiene medida?:</p>
                    <div>
                        <label>
                            <input type="radio" value="1" name="editarFormulario.tiene_medida"
                                wire:model.defer="editarFormulario.tiene_medida">
                            Si
                        </label>
                        <label>
                            <input type="radio" value="0" name="editarFormulario.tiene_medida"
                                wire:model.defer="editarFormulario.tiene_medida">
                            No
                        </label>
                    </div>
                    @error('editarFormulario.tiene_medida')
                        <span>{{ $message }}</span>
                    @enderror
                </div>
            </x-slot>
            <x-slot name="footer">
                <div class="contenedor_pie_modal">
                    <button wire:click="$set('editarFormulario.abierto', false)" wire:loading.attr="disabled"
                        type="submit">Cancelar</button>

                    <button wire:click="actualizarSubcategoria" wire:loading.attr="disabled"
                        wire:target="actualizarSubcategoria" type="submit">Editar</button>
                </div>
            </x-slot>
        </x-jet-dialog-modal>
    @endif
</div>

<!--SCRIPT-->
@push('script')
    <script>
        Livewire.on('eliminarSubcategoriaModal', subcategoriaId => {
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
                    Livewire.emitTo('administrador.subcategoria.subcategoria-livewire',
                        'eliminarSubcategoria', subcategoriaId);
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
