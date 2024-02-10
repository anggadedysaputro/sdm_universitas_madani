
<header class="navbar-expand-md">
    <div class="collapse navbar-collapse" id="navbar-menu">
        <div class="navbar">
            <div class="container-xl">
                <ul class="navbar-nav">
                    @foreach (session('menu') as $value)
                        @if (!empty($value['children']))
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#navbar-base" data-bs-toggle="dropdown"
                                data-bs-auto-close="outside" role="button" aria-expanded="false">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <!-- Download SVG icon from http://tabler-icons.io/i/package -->
                                    <i class="{{ $value['nama_icon'] }}"></i>
                                </span>
                                <span class="nav-link-title">
                                    {{ $value['nama'] }}
                                </span>
                            </a>
                            <div class="dropdown-menu">
                                <div class="dropdown-menu-columns">
                                    <div class="dropdown-menu-column">
                                        {{ buildMenu($value['children']); }}
                                    </div>
                                </div>
                            </div>
                        </li>
                        @else
                            <li class="nav-item dropdown">
                                <a class="nav-link" href="{{ empty($value['link']) ? '#' : route($value['link']) }}">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
                                        <i class="{{ $value['nama_icon'] }}"></i>
                                    </span>
                                    <span class="nav-link-title">
                                        {{ $value['nama'] }}
                                    </span>
                                </a>
                            </li>
                        @endif
                    @endforeach
                   
                </ul>
                <div class="my-2 my-md-0 flex-grow-1 flex-md-grow-0 order-first order-md-last">
                    @yield('search')
                </div>
            </div>
        </div>
    </div>
</header>