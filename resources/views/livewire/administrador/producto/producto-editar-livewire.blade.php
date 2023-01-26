<div>
    <!--SEO-->
    @section('tituloPagina', 'EDITAR PRODUCTO')

    <!--TITULO-->
    <h1>EDITAR PRODUCTO</h1>

    <!--BOTONES-->
    <a href="{{ route('administrador.producto.index') }}">
        <i class="fa-solid fa-arrow-left-long"></i> Regresar</a>
    <button wire:click="$emit('eliminarProductoModal')">
        Eliminar producto
    </button>
    <a href="{{ route('administrador.producto.crear') }}">Crear Nuevo Producto</a>

    <div>
        <p>Codigo de barras</p>
        {!! DNS1D::getBarcodeSVG($producto->sku, 'C128', 2, 45, true) !!}
        {{--<img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($producto->sku, 'C128', 2, 33) }}" alt="">--}}

        <a download="{{ $this->producto->sku . '.png' }}"
            href="data:image/png;base64,{{ DNS1D::getBarcodePNG($producto->sku, 'C128', 2, 33) }}">Descargar Codigo de Barra</a>
    </div>
    <hr>
    <div>
        <a href="{{ route('producto.index', $producto->slug) }}" target="_blank">
            Ver producto</a>

        <a href="{{ route('producto.redirigir.qr', $producto->slug) }}" target="_blank">
            Redirigir por QR</a>

        <p>QR</p>
        {!! QrCode::size(200)->generate(route('producto.redirigir.qr', $producto->slug)) !!}
        <button wire:click="descargarQR">
            Descargar QR
        </button>
    </div>

    <!--FORMULARIO-->
    <div x-data>
        <!--PROVEEDOR-->
        <div>
            <p>Proveedores: </p>
            <select wire:model="proveedor_id">
                <option value="" selected disabled>Seleccione un proveedor</option>
                @foreach ($proveedores as $proveedor)
                    <option value="{{ $proveedor->id }}">{{ $proveedor->nombre }}</option>
                @endforeach
            </select>
            @error('proveedor_id')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <!--CATEGORIAS-->
        <div>
            <p>Categorias: </p>
            <select wire:model="categoria_id">
                <option value="" selected disabled>Seleccione una categoría</option>
                @foreach ($categorias as $categoria)
                    <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                @endforeach
            </select>
            @error('categoria_id')
                <span>{{ $message }}</span>
            @enderror
        </div>

         <!--SUBCATEGORIAS-->
         <div>
            <p>Subcategorias: </p>
            <select wire:model="producto.subcategoria_id">
                <option value="" selected disabled>Seleccione una subcategoría</option>
                @foreach ($subcategorias as $subcategoria)
                    <option value="{{ $subcategoria->id }}">{{ $subcategoria->nombre }}</option>
                @endforeach
            </select>
            @if ($this->subcategoria)
                <!--Propiedad computada-->
                @if ($this->subcategoria->tiene_color && !$this->subcategoria->tiene_medida)
                    <code>El producto varia en Color</code>
                @elseif(!$this->subcategoria->tiene_color && $this->subcategoria->tiene_medida)
                    <code>El producto varia en Medida</code>
                @elseif($this->subcategoria->tiene_color && $this->subcategoria->tiene_medida)
                    <code>El producto varia en Color y Medida</code>
                @else
                    <code>El producto No tiene Variación</code>
                @endif
            @endif
            @error('producto.subcategoria_id')
                <span>{{ $message }}</span>
            @enderror
        </div>

        
        <!--MARCAS-->
        <div>
            <p>Marca: </p>
            <select wire:model="producto.marca_id">
                <option value="" selected disabled>Seleccione una marca</option>
                @foreach ($marcas as $marca)
                    <option value="{{ $marca->id }}">{{ $marca->nombre }}</option>
                @endforeach
            </select>
            @error('producto.marca_id')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <!--TAGS-->
        <div>
            <p>Tags: </p>
            @if ($tagsDb->count())
                <div>
                    @foreach ($tagsDb as $tagsDbItem)
                        <label>
                            <input type="checkbox" name="tags[]" wire:model.defer="tags"
                                value="{{ $tagsDbItem->id }}">
                            <span> {{ $tagsDbItem->nombre }}</span>
                        </label>
                    @endforeach
                </div>
                @error('tags')
                    <span>{{ $message }}</span>
                @enderror
            @endif
        </div>

        <!--NOMBRE-->
        <div>
            <p>Nombre: </p>
            <input type="text" wire:model="producto.nombre">
            @error('producto.nombre')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <!--SLUG-->
        <div>
            <p>Slug: </p>
            <input type="text" wire:model="slug">
            @error('slug')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <!--SKU-->
        <div>
            <p>SKU: </p>
            <input type="text" wire:model="sku">
            @error('sku')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <!--PRECIO REAL-->
        <div>
            <p>Precio real: </p>
            <input type="number" wire:model="producto.precio_real">
            @error('producto.precio_real')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <!--PRECIO VENTA-->
        <div>
            <p>Precio oferta: </p>
            <input type="number" wire:model="producto.precio_venta">
            @if ($producto->precio_venta)
                @if ($producto->precio_venta == $producto->precio_real)
                    <code>No tiene descuento.</code>
                @elseif($producto->precio_real > $producto->precio_venta)
                    <code>Tiene un descuento de:
                        %{{ 100 - (100 * $producto->precio_venta) / $producto->precio_real }}</code>
                @else
                    <code>El precio de Oferta tiene que ser menor al precio Real.</code>
                @endif
            @endif
            @error('producto.precio_venta')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <!--STOCK TOTAL-->
        <div>
            <p>Stock: </p>
            <input type="number" wire:model="stock_total">
            @error('stock_total')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <!--DESCRIPCIÓN CORTA-->
        <div>
            <p>Descripción corta: </p>
            <input type="text" wire:model="producto.descripcion">
            @error('producto.descripcion')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <!--INFORMACIÓN-->
        <div>
            <div wire:ignore>
                <p>Información: </p>
                <textarea rows="3"wire:model="producto.informacion" x-data x-init="ClassicEditor.create($refs.miEditor, {
                        toolbar: ['bold', 'italic', 'link', 'undo', 'redo', 'bulletedList', 'uploadImage'],
                        simpleUpload: {
                            uploadUrl: '{{ route('administrador.ckeditor.upload') }}'
                        }
                    })
                    .then(function(editor) {
                        editor.model.document.on('change:data', () => {
                            @this.set('producto.informacion', editor.getData())
                        })
                    })
                    .catch(error => {
                        console.error(error);
                    });" x-ref="miEditor">
            </textarea>
            </div>
            @error('producto.informacion')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <!--PUNTOS A GANAR-->
        <div>
            <p>Puntos a ganar: </p>
            <input type="number" wire:model="producto.puntos_ganar">
            @error('producto.puntos_ganar')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <!--LINK VIDEO-->
        <div>
            <p>Link video YouTube embed: </p>
            <input type="text" wire:model="link_video">
            @error('link_video')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <!--TIENE IGV-->
        <div>
            <p>¿Incluye IGV: </p>
            <div>
                <label>
                    <input type="radio" value="0" wire:model.defer="producto.incluye_igv"
                        x-on:click="$wire.incluye_igv = 0">
                    No
                </label>
                <label>
                    <input type="radio" value="1" wire:model.defer="producto.incluye_igv"
                        x-on:click="$wire.incluye_igv = 1">
                    Si
                </label>
            </div>
            @error('producto.incluye_igv')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <!--TIENE DETALLE-->
        <div>
            <p class="estilo_nombre_input">¿Tiene detalle?: </p>
            <div>
                <label>
                    <input type="radio" value="0" name="tiene_detalle" wire:model.defer="producto.tiene_detalle"
                        x-on:click="$wire.tiene_detalle = false">
                    No
                </label>
                <label>
                    <input type="radio" value="1" name="tiene_detalle" wire:model.defer="producto.tiene_detalle"
                        x-on:click="$wire.tiene_detalle = true">
                    Si
                </label>
            </div>
            @error('producto.tiene_detalle')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <!--DETALLE-->
        <div wire:ignore x-show="$wire.tiene_detalle">
            <p>Detalle: </p>
            <textarea rows="3" wire:model="detalle" id="detalle" x-data x-init="ClassicEditor.create($refs.miEditor2, {
                    toolbar: ['insertTable', 'bold'],
                    table: {
                        contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells']
                    }
                })
                .then(function(editor2) {
                    editor2.model.document.on('change:data', () => {
                        @this.set('detalle', editor2.getData())
                    })
                })
                .catch(error => {
                    console.error(error);
                });" x-ref="miEditor2">
            </textarea>
        </div>
        @error('detalle')
            <span>{{ $message }} </span>
        @enderror

        <!--ESTADO-->
        @livewire('administrador.producto.producto-estado-livewire', ['productoEstado' => $producto], key('producto-estado-livewire-' . $producto->id))

        <!--DROPZONE-->
        <div wire:ignore>
            <form action="{{ route('administrador.producto.dropzone', $producto) }}" method="POST" class="dropzone"
                id="my-awesome-dropzone"></form>
        </div>

        <!--IMAGENES-->
        @if ($producto->imagenes->count())
            <div>
                <p>Imagenes: </p>
                <div id="sortableimagenes">
                    @foreach ($producto->imagenes->sortBy('posicion') as $key => $imagen)
                        <div wire:key="imagen-{{ $imagen->id }}" style="position: relative;"
                            data-id="{{ $imagen->id }}">
                            <img class="handle2 cursor-grab" style="width: 100px; height: 100px; object-fit: cover;"
                                src="{{ Storage::url($imagen->imagen_ruta) }}" alt="">
                            <button wire:click="eliminarImagen({{ $imagen->id }})" wire:loading.attr="disabled"
                                wire:target="eliminarImagen({{ $imagen->id }})">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
        <br>
        <!--ENVIAR-->
        <div>
            <button wire:loading.attr="disabled" wire:target="editarProducto" wire:click="editarProducto">
                Actualizar producto
            </button>
        </div>
    </div>
</div>

@push('script')
    <script>
        new Sortable(sortableimagenes, {
            handle: '.handle2',
            animation: 150,
            ghostClass: 'bg-blue-100',
            store: {
                set: function(sortable) {
                    const sorts = sortable.toArray();
                    //console.log(sorts);
                    Livewire.emitTo('administrador.producto.producto-editar-livewire',
                        'cambiarPosicionImagenes', sorts);
                },
                onStart: function(evt) {
                    console.log(evt.oldIndex);
                },
            }
        });

        Dropzone.options.myAwesomeDropzone = {
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            dictDefaultMessage: "Arrastre una imagen al recuadro.",
            acceptedFiles: 'image/*',
            paramName: "file",
            maxFilesize: 2,
            complete: function(file) {
                this.removeFile(file);
            },
            queuecomplete: function() {
                Livewire.emit('dropImagenes');
            }
        };


        Livewire.on('eliminarProductoModal', () => {
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
                    Livewire.emitTo('administrador.producto.producto-editar-livewire',
                        'eliminarProducto');
                    Swal.fire(
                        '¡Eliminado!',
                        'Eliminaste correctamente.',
                        'success'
                    )
                }
            })
        })
    </script>
@endpush
