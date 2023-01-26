<div>
    <!--SEO-->
    @section('tituloPagina', 'CREAR PRODUCTO')

    <!--TITULO-->
    <h1>CREAR PRODUCTO</h1>

    <!--BOTONES-->
    <a href="{{ route('administrador.producto.index') }}">
        <i class="fa-solid fa-arrow-left-long"></i> Regresar</a>

    <!--FORMULARIO-->
    <form wire:submit.prevent="crearProducto" x-data>

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
            <select wire:model="subcategoria_id">
                <option value="" selected disabled>Seleccione una subcategoría</option>
                @foreach ($subcategorias as $subcategoria)
                    <option value="{{ $subcategoria->id }}">{{ $subcategoria->nombre }}</option>
                @endforeach
            </select>
            @if ($subcategoria_id)
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
            @error('subcategoria_id')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <!--MARCAS-->
        <div>
            <p>Marca: </p>
            <select wire:model="marca_id">
                <option value="" selected disabled>Seleccione una marca</option>
                @foreach ($marcas as $marca)
                    <option value="{{ $marca->id }}">{{ $marca->nombre }}</option>
                @endforeach
            </select>
            @error('marca_id')
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
            <input type="text" wire:model="nombre">
            @error('nombre')
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
            <input type="number" wire:model="precio_real">
            @error('precio_real')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <!--PRECIO VENTA-->
        <div>
            <p>Precio oferta: </p>
            <input type="number" wire:model="precio_venta">
            @if ($precio_venta)
                @if ($precio_venta == $precio_real)
                    <code>No tiene descuento.</code>
                @elseif($precio_real > $precio_venta)
                    <code>Tiene un descuento de: %{{ 100 - (100 * $precio_venta) / $precio_real }}</code>
                @else
                    <code>El precio de Oferta tiene que ser menor al precio Real.</code>
                @endif
            @endif
            @error('precio_venta')
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
            <input type="text" wire:model="descripcion">
            @error('descripcion')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <!--INFORMACIÓN-->
        <div>
            <div wire:ignore>
                <p>Información: </p>
                <textarea rows="3"wire:model="informacion" x-data x-init="ClassicEditor.create($refs.miEditor, {
                        toolbar: ['bold', 'italic', 'link', 'undo', 'redo', 'bulletedList', 'uploadImage'],
                        simpleUpload: {
                            uploadUrl: '{{ route('administrador.ckeditor.upload') }}'
                        }
                    })
                    .then(function(editor) {
                        editor.model.document.on('change:data', () => {
                            @this.set('informacion', editor.getData())
                        })
                    })
                    .catch(error => {
                        console.error(error);
                    });" x-ref="miEditor">
            </textarea>
            </div>
            @error('informacion')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <!--PUNTOS A GANAR-->
        <div>
            <p>Puntos a ganar: </p>
            <input type="number" wire:model="puntos_ganar">
            @error('puntos_ganar')
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
                    <input type="radio" value="0" wire:model.defer="incluye_igv"
                        x-on:click="$wire.incluye_igv = 0">
                    No
                </label>
                <label>
                    <input type="radio" value="1" wire:model.defer="incluye_igv"
                        x-on:click="$wire.incluye_igv = 1">
                    Si
                </label>
            </div>
            @error('incluye_igv')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <!--TIENE DETALLE-->
        <div>
            <p class="estilo_nombre_input">¿Tiene detalle?: </p>
            <div>
                <label>
                    <input type="radio" value="0" name="tiene_detalle" wire:model.defer="tiene_detalle"
                        x-on:click="$wire.tiene_detalle = false">
                    No
                </label>
                <label>
                    <input type="radio" value="1" name="tiene_detalle" wire:model.defer="tiene_detalle"
                        x-on:click="$wire.tiene_detalle = true">
                    Si
                </label>
            </div>
            @error('tiene_detalle')
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
        <div>
            <p>Estado: </p>
            <div>
                <label>
                    <input type="radio" value="0" wire:model.defer="estado">
                    Desactivado
                </label>
                <label>
                    <input type="radio" value="1" wire:model.defer="estado">
                    Activado
                </label>
            </div>
            @error('estado')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <!--IMAGENES-->
        <div>
            <p>Imagenes: </p>
            <div style="width: 100px; height: 100px;">
                <img style="width: 100px; height: 100px;" src="{{ asset('imagenes/producto/sin_foto_producto.png') }}">
                <div>
                    <label for="imagenes">

                        Subir <i class="fa-solid fa-camera"></i>

                    </label>
                </div>
            </div>
            <div id="sortableimagenes">
                @if ($imagenes)
                    @foreach ($imagenes as $key => $imagen)
                        <div wire:key="{{ $loop->index }}" data-id="{{ $key }}" style="position: relative;">
                            <img class="handle2 cursor-grab" style="width: 100px; height: 100px; object-fit: cover;"
                                src="{{ $imagen->temporaryUrl() }}">
                            <p wire:click="eliminarImagen({{ $loop->index }})">
                                <i class="fa-solid fa-xmark" style="color: red;"></i>
                            </p>
                        </div>
                    @endforeach
                @endif
            </div>
            <br>
            @error('imagenes')
                <span>{{ $message }} </span>
            @enderror

            <input type="file" wire:model="imagenes" multiple style="display: none" id="imagenes">

        </div>
        <br>
        <!--ENVIAR-->
        <div>
            <input type="submit" value="Crear Producto">
        </div>
    </form>
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
                    Livewire.emitTo('administrador.producto.producto-crear-livewire',
                        'cambiarPosicionImagenes', sorts);
                },
                onStart: function(evt) {
                    console.log(evt.oldIndex);
                },
            }
        });

        $(document).ready(function() {
            $('.select_categorias_producto').select2();
        });

        $(document).ready(function() {
            $('.select_subcategorias_producto').select2();
        });

        $(document).ready(function() {
            $('.select_proveedores_producto').select2();
        });

        $(document).ready(function() {
            $('.select_tags_producto').select2();
        });
    </script>
@endpush
