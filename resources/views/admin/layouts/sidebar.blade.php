<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <a href="{{ route('home') }}" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ URL::asset('build/images/logo-sm.png') }}" alt="logo" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('build/images/logo-dark.png') }}" alt="logo" height="22">
            </span>
        </a>
        <a href="{{ route('home') }}" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ URL::asset('build/images/logo-sm.png') }}" alt="logo" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('build/images/logo-light.png') }}" alt="logo" height="22">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-3xl header-item float-end btn-vertical-sm-hover"
                id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">
            <ul class="navbar-nav" id="navbar-nav">

                {{-- Menu Title --}}
                <li class="menu-title"><span>@lang('translation.menu')</span></li>

                @php
                    $menu = config('role_permissions.menu');
                @endphp

                {{-- Dynamic Menu Rendering --}}
                @foreach($menu as $item)
                    @if(Auth::user()->hasPermission($item['permission']))
                        @if(isset($item['children']) && count($item['children']) > 0)
                            <!-- Parent menu with children -->
                            <li class="nav-item">
                                <a class="nav-link menu-link collapsed"
                                   href="#menu-{{ Str::slug($item['title']) }}"
                                   data-bs-toggle="collapse"
                                   role="button"
                                   aria-expanded="false"
                                   aria-controls="menu-{{ Str::slug($item['title']) }}">
                                    <i class="{{ $item['icon'] }}"></i>
                                    <span>{{ $item['title'] }}</span>
                                </a>
                                <div class="collapse menu-dropdown" id="menu-{{ Str::slug($item['title']) }}">
                                    <ul class="nav nav-sm flex-column">
                                        @foreach($item['children'] as $child)
                                            @if(Auth::user()->hasPermission($child['permission']))
                                                <li class="nav-item">
                                                    <a href="{{ route($child['route']) }}" class="nav-link">
                                                        <i class="{{ $child['icon'] }} me-1"></i>
                                                        {{ $child['title'] }}
                                                    </a>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </li>
                        @else
                            <!-- Single menu item -->
                            <li class="nav-item">
                                <a href="{{ route($item['route']) }}" class="nav-link">
                                    <i class="{{ $item['icon'] }}"></i>
                                    <span>{{ $item['title'] }}</span>
                                </a>
                            </li>
                        @endif
                    @endif
                @endforeach

                {{-- Extra: User Management only for Super Admin --}}
                @if(Auth::user()->role === 'super-admin')
                    <li class="nav-item">
                        <a href="{{ route('user.index') }}" class="nav-link">
                            <i class="ri-team-line"></i>
                            <span>Users</span>
                        </a>
                    </li>
                @endif

{{-- Cart & Orders Menu --}}
<li class="menu-title"><span>Shop Management</span></li>

<li class="nav-item">
    <a href="{{ route('cart.index') }}" class="nav-link">
        <i class="ri-shopping-cart-line"></i>
        <span>Carts</span>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('admin.orders.index') }}" class="nav-link">
        <i class="ri-file-list-line"></i>
        <span>Orders</span>
    </a>
</li>



            </ul>
        </div>
    </div>

    <div class="sidebar-background"></div>
</div>
<!-- Left Sidebar End -->
