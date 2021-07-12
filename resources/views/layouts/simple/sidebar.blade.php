<div class="sidebar-wrapper">
    <div>
        <div class="logo-wrapper">
            <a href=""><img class="img-fluid for-light" src="{{ asset('assets/images/logo/logo.png') }}" alt=""><img
                    class="img-fluid for-dark" src="{{ asset('assets/images/logo/logo_dark.png') }}" alt=""></a>
            <div class="back-btn"><i class="fa fa-angle-left"></i></div>
            <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="grid"> </i></div>
        </div>
        <div class="logo-icon-wrapper"><a href=""><img class="img-fluid"
                    src="{{ asset('assets/images/logo/logo-icon.png') }}" alt=""></a></div>
        <nav class="sidebar-main">
            <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
            <div id="sidebar-menu">
                <ul class="sidebar-links" id="simple-bar">
                    <li class="sidebar-main-title">
                        {{-- <div>
							<h6 class="lan-1">{{ trans('lang.General') }} </h6>
                     		<p class="lan-2">{{ trans('lang.Dashboards,widgets & layout.') }}</p>
						</div> --}}
                    </li>
                    {{-- <li class="back-btn">
						<a href=""><img class="img-fluid" src="{{asset('assets/images/logo/logo-icon.png')}}" alt=""></a>
						<div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2" aria-hidden="true"></i></div>
					</li> --}}

                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title link-nav" href="/home">
                            <i data-feather="home"> </i><span>Dashboard</span>
                        </a>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title link-nav" href="/user">
                            <i data-feather="users"> </i><span>Usuarios</span>
                        </a>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="#" data-bs-original-title="" title="">
                            <i data-feather="shopping-bag"> </i><span>Productos</span>
                            <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                        </a>
                        <ul class="sidebar-submenu" style="display: none;">
                            <li><a href="/products">Lista de Productos</a></li>
                            <li><a href="/stock">Alerta de Stock</a></li>
                            <li><a href="/categorie">Categorias</a></li>
                            <li><a href="/brand">Marcas</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title link-nav" href="/providers">
                            <i data-feather="truck"></i><span>Proveedores</span>
                        </a>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title link-nav" href="/adjustment">
                            <i data-feather="shuffle"></i><span>Ajustes</span>
                        </a>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title link-nav" href="/purchases">
                            <i data-feather="package"></i><span>Compras</span>
                        </a>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title link-nav" href="/sales">
                            <i data-feather="shopping-cart"></i><span>Ventas</span>
                        </a>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title link-nav" href="/kardex">
                            <i data-feather="refresh-ccw"></i><span>Kardex</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </nav>
    </div>
</div>
