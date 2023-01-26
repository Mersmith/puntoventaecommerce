<div>
    <!--SEO-->
    @section('tituloPagina', 'Proveedores')

    <!--TITULO-->
    <h1>Proveedores</h1>

    <!--FORMULARIOS-->
    <form wire:submit.prevent="crearProveedor">
        <!--NOMBRE-->
        <div>
            <p>Nombre: </p>
            <input type="text" wire:model="crearFormulario.nombre">
            @error('crearFormulario.nombre')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <!--EMAIL-->
        <div>
            <p>Email: </p>
            <input type="email" wire:model="crearFormulario.email">
            @error('crearFormulario.email')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <!--RUC-->
        <div>
            <p>RUC: </p>
            <input type="number" wire:model="crearFormulario.ruc">
            @error('crearFormulario.ruc')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <!--DIRECCIÓN-->
        <div>
            <p>Dirección: </p>
            <input type="text" wire:model="crearFormulario.direccion">
            @error('crearFormulario.direccion')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <!--CELULAR-->
        <div>
            <p>Celular: </p>
            <input type="tel" wire:model="crearFormulario.celular">
            @error('crearFormulario.celular')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <!--ENVIAR-->
        <div>
            <input type="submit" value="Crear Proveedor">
        </div>
    </form>


    @if ($proveedores->count())
        <!--SUBTITULO-->
        <h1>Lista Proveedores</h1>

        <!--TABLA-->
        <table>
            <thead>
                <tr>
                    <th>
                        Nombre</th>
                    <th>
                        Email</th>
                    <th>
                        RUC</th>
                    <th>
                        Dirección</th>
                    <th>
                        Celular</th>
                    <th>
                        Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($proveedores as $proveedor)
                    <tr>
                        <td>

                            {{ $proveedor->nombre }}
                        </td>
                        <td>
                            {{ $proveedor->email }}
                        </td>
                        <td>
                            {{ $proveedor->ruc }}
                        </td>
                        <td>
                            {{ $proveedor->direccion }}
                        </td>
                        <td>
                            {{ $proveedor->celular }}
                        </td>
                        <td>
                            <a wire:click="editarProveedor('{{ $proveedor->id }}')">
                                <span><i class="fa-solid fa-pencil"></i></span>
                                Editar</a> |
                            <a wire:click="$emit('eliminarProveedorModal', '{{ $proveedor->id }}')">
                                <span><i class="fa-solid fa-trash"></i></span>
                                Eliminar</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No hay proveedores.</p>
    @endif

    @if ($proveedor)
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

                <!--EMAIL-->
                <div>
                    <p>Email: </p>
                    <input type="email" wire:model="editarFormulario.email">
                    @error('editarFormulario.email')
                        <span>{{ $message }}</span>
                    @enderror
                </div>

                <!--RUC-->
                <div>
                    <p>RUC: </p>
                    <input type="number" wire:model="editarFormulario.ruc">
                    @error('editarFormulario.ruc')
                        <span>{{ $message }}</span>
                    @enderror
                </div>

                <!--DIRECCIÓN-->
                <div>
                    <p>Dirección: </p>
                    <input type="text" wire:model="editarFormulario.direccion">
                    @error('editarFormulario.direccion')
                        <span>{{ $message }}</span>
                    @enderror
                </div>

                <!--CELULAR-->
                <div>
                    <p>Celular: </p>
                    <input type="tel" wire:model="editarFormulario.celular">
                    @error('editarFormulario.celular')
                        <span>{{ $message }}</span>
                    @enderror
                </div>

            </x-slot>
            <x-slot name="footer">
                <div class="contenedor_pie_modal">
                    <button wire:click="$set('editarFormulario.abierto', false)" wire:loading.attr="disabled"
                        type="submit">Cancelar</button>

                    <button wire:click="actualizarProveedor" wire:loading.attr="disabled"
                        wire:target="actualizarProveedor" type="submit">Editar</button>
                </div>
            </x-slot>
        </x-jet-dialog-modal>
    @endif
</div>

<!--SCRIPT-->
@push('script')
    <script>
        Livewire.on('eliminarProveedorModal', proveedorId => {
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
                    Livewire.emitTo('administrador.proveedor.proveedor-livewire',
                        'eliminarProveedor', proveedorId);
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
