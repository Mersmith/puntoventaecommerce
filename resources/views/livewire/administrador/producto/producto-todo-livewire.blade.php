<div>
    <!--SEO-->
    @section('tituloPagina', 'PRODUCTOS')

    <!--TITULO-->
    <h1>PRODUCTOS</h1>

    <!--BOTONES-->
    <a href="{{ route('administrador.producto.crear') }}">
        <i class="fa-solid fa-arrow-left-long"></i> Crear producto</a>

    @if ($productos->count())
        <!--SUBTITULO-->
        <h2>Lista Productos</h2>

        <!--BUSCADOR-->
        <div>
            <input type="text" wire:model="buscarProducto"
                placeholder="Ingrese el nombre del producto que quiere buscar.">
        </div>

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
                        Categoría</th>
                    <th>
                        Estado</th>
                    <th>
                        Precio</th>
                    <th>
                        Proveedor</th>
                    <th>
                        Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($productos as $producto)
                    <tr>
                        <td>
                            <div style="width: 20px; height: 20px;">
                                @if ($producto->imagenes->count())
                                    <img src="{{ Storage::url($producto->imagenes->first()->imagen_ruta) }}"
                                        alt="" />
                                @else
                                    <img src="{{ asset('imagenes/producto/sin_foto_producto.png') }}">
                                @endif
                            </div>
                        </td>
                        <td>
                            {{ $producto->nombre }}
                        </td>
                        <td>
                            {{ $producto->slug }}
                        </td>
                        <td>
                            {{ $producto->subcategoria->categoria->nombre}}
                        </td>
                        <td>
                            @switch($producto->estado)
                                @case(0)
                                    <span>
                                        Desactivado
                                    </span>
                                @break

                                @case(1)
                                    <span>
                                        Activado
                                    </span>
                                @break

                                @default
                            @endswitch
                        </td>
                        <td>
                            {{ $producto->precio_venta }}
                        </td>
                        <td>
                            {{ $producto->proveedor->nombre }}
                        </td>
                        <td>
                            <a href="{{ route('administrador.producto.editar', $producto) }}">
                                <span><i class="fa-solid fa-pencil"></i></span>
                                Editar</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No hay productos.</p>
    @endif
    @if ($productos->hasPages())
        <div>
            {{ $productos->links() }}
        </div>
    @endif
</div>
