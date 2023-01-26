<header class="contenedor_navbar" x-data="iconos" x-on:click.away="cerrarCategorias(); cerrarCarrito()"
    @resize.window="anchoPantalla = window.innerWidth">
    <!-- GRID MENU -->
    <nav class="navbar" x-data="sidebar" x-on:click.away="cerrarSidebar()">
        <!-- HAMBURGUESA -->
        <div x-on:click="abrirSidebar" class="contenedor_hamburguesa">
            <i class="fa-solid fa-bars" style="color: #666666;"></i>
        </div>
        <!-- LOGO -->
        <div class="contenedor_logo">
            <a href="{{ route('inicio') }}">
                <img src="{{ asset('imagenes/empresa/logo.png') }}" alt="" />
            </a>
        </div>
        <!-- BUSCADOR -->
        <div :class="{ 'block': abiertoSidebar, 'block': !abiertoSidebar }" class="contenedor_menu_link">
            <div class="sidebar_logo">
                <img src="{{ asset('imagenes/empresa/logo.png') }}" alt="" />
                <i x-on:click="cerrarSidebar" style="cursor: pointer; color: #666666;" class="fa-solid fa-xmark"></i>
            </div>
            <hr>
            <p>Buscador</p>
            <!-- <hr> -->
            <!-- FIN MENU-PRINCIPAL -->
        </div>
        <!-- ICONOS -->
        <div class="contenedor_iconos">
            <a x-on:click="abrirCategorias">
                <i class="fa-solid fa-bars-progress" style="color: #666666;"></i>
            </a>
            <a href="">
                <i class="fa-solid fa-store" style="color: #666666;"></i>
            </a>
            @auth
                <!-- Settings Dropdown -->
                <div class="ml-3 relative">
                    <x-jet-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                @if (Auth::user()->rol == 'administrador')
                                    @if (Auth::user()->administrador && Auth::user()->administrador->imagen_ruta)
                                        <img class="h-8 w-8 rounded-full object-cover"
                                            src="{{ Storage::url(Auth::user()->administrador->imagen_ruta) }}"
                                            alt="{{ Auth::user()->administrador->nombre }}" />
                                    @else
                                        <img class="h-8 w-8 rounded-full object-cover"
                                            src="{{ asset('imagenes/perfil/sin_foto_perfil.png') }}" />
                                    @endif
                                @else
                                    @if (Auth::user()->cliente && Auth::user()->cliente->imagen_ruta)
                                        <img class="h-8 w-8 rounded-full object-cover"
                                            src="{{ Storage::url(Auth::user()->cliente->imagen_ruta) }}"
                                            alt="{{ Auth::user()->cliente->nombre }}" />
                                    @else
                                        <img class="h-8 w-8 rounded-full object-cover"
                                            src="{{ asset('imagenes/perfil/sin_foto_perfil.png') }}" />
                                    @endif
                                @endif
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <!-- Menu Cliente -->
                            @if (Auth::user()->rol == 'administrador')
                                <x-jet-dropdown-link href="">
                                    {{ __('Perfil') }}
                                </x-jet-dropdown-link>

                                <x-jet-dropdown-link href="#">
                                    {{ __('Ventas') }}
                                </x-jet-dropdown-link>
                            @else
                                <x-jet-dropdown-link href="">
                                    {{ __('Perfil') }}
                                </x-jet-dropdown-link>

                                <x-jet-dropdown-link href="">
                                    {{ __('Ordenes') }}
                                </x-jet-dropdown-link>
                            @endif

                            <div class="border-t border-gray-100"></div>

                            <!-- Cerrar Sesión -->
                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf

                                <x-jet-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                                    {{ __('Cerrar') }}
                                </x-jet-dropdown-link>
                            </form>
                        </x-slot>
                    </x-jet-dropdown>
                </div>
            @else
                <x-jet-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <i class="fa-solid fa-user" style="color: #666666;"></i>
                    </x-slot>
                    <x-slot name="content">
                        <x-jet-dropdown-link href="">
                            {{ __('Entrar') }}
                        </x-jet-dropdown-link>
                    </x-slot>
                </x-jet-dropdown>
            @endauth
            <a x-on:click="abrirCarrito">
                <i class="fa-solid fa-cart-shopping" style="color: #666666;"></i>
            </a>
        </div>
    </nav>

    <div :class="{ 'block': abiertoCategorias, 'block': !abiertoCategorias }" class="contenedor_menu_categorias">
        Categorias
    </div>

    <div :class="{ 'block': abiertoCarrito, 'block': !abiertoCarrito }" class="contenedor_menu_carrito">
        Carrito
    </div>
</header>

@push('script')
    <script>
        function sidebar() {
            return {
                abiertoSidebar: false,
                toggleSidebar() {
                    this.abiertoSidebar = !this.abiertoSidebar
                },
                abrirSidebar() {
                    if (this.abiertoSidebar) {
                        this.abiertoSidebar = false;
                        document.querySelector(".contenedor_menu_link").style.left = "-100%";
                    } else {
                        this.abiertoSidebar = true;
                        document.querySelector(".contenedor_menu_link").style.left = "0";
                    }
                },
                cerrarSidebar() {
                    this.abiertoSidebar = false;
                    document.querySelector(".contenedor_menu_link").style.left = "-100%";
                }
            }
        }

        function iconos() {
            var width = window.innerWidth;
            return {
                abiertoCategorias: false,
                abiertoCarrito: false,
                anchoPantalla: width,

                cerrarCategorias() {
                    this.abiertoCategorias = false;
                    if (this.anchoPantalla > 500) {
                        document.querySelector(".contenedor_menu_categorias").style.top = "0";
                    } else {
                        document.querySelector(".contenedor_menu_categorias").style.left = "-100%";
                    }
                },
                cerrarCarrito() {
                    this.abiertoCarrito = false;
                    document.querySelector(".contenedor_menu_carrito").style.right = "-100%";
                },

                toggleCategorias() {
                    this.abiertoCategorias = !this.abiertoCategorias
                },
                toggleCarrito() {
                    this.abiertoCarrito = !this.abiertoCarrito
                },
                abrirCategorias() {
                    if (this.anchoPantalla > 500) {
                        if (this.abiertoCategorias) {
                            this.abiertoCategorias = false;
                            document.querySelector(".contenedor_menu_categorias").style.top = "0";
                        } else {
                            this.abiertoCategorias = true;
                            document.querySelector(".contenedor_menu_categorias").style.top = "150px";
                        }
                        this.cerrarCarrito();
                    } else {
                        if (this.abiertoCategorias) {
                            this.abiertoCategorias = false;
                            document.querySelector(".contenedor_menu_categorias").style.left = "-100%";
                        } else {
                            this.abiertoCategorias = true;
                            document.querySelector(".contenedor_menu_categorias").style.left = "0";
                        }
                        this.cerrarCarrito();
                    }
                },
                abrirCarrito() {
                    if (this.abiertoCarrito) {
                        this.abiertoCarrito = false;
                        document.querySelector(".contenedor_menu_carrito").style.right = "-100%";
                    } else {
                        this.abiertoCarrito = true;
                        document.querySelector(".contenedor_menu_carrito").style.right = "0";
                    }
                    this.cerrarCategorias();
                }
            }
        }
    </script>
@endpush
