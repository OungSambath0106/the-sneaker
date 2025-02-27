<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link px-1 ml-1" data-widget="pushmenu" href="#" role="button">@include('svgs.close_siebar')</a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Navbar Search -->
        <li class="nav-item">
            <div class="navbar-search-block">
                <form class="form-inline">
                    <div class="input-group input-group-sm">
                        <input class="form-control form-control-navbar" type="search" placeholder="Search"
                            aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-navbar" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                            <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </li>

        <!-- Language Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="flag-icon flag-icon-{{ ($current_locale == 'en') ? 'gb' : $current_locale }}"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right p-0">
                @foreach($available_locales as $locale_name => $available_locale)
                    @if($available_locale === $current_locale)
                        <a href="{{ route('change_language', $available_locale) }}" class="dropdown-item text-capitalize active">
                            <i class="flag-icon flag-icon-{{ ($available_locale == 'en') ? 'gb' : $available_locale }} mr-2"></i> {{ $locale_name }}
                        </a>
                    @else
                        <a href="{{ route('change_language', $available_locale) }}" class="dropdown-item text-capitalize">
                            <i class="flag-icon flag-icon-{{ ($available_locale == 'en') ? 'gb' : $available_locale }} mr-2"></i> {{ $locale_name }}
                        </a>
                    @endif
                @endforeach
            </div>
        </li>

        <li class="nav-item dropdown user-menu mt-1">
            <a href="#" class="nav-link dropdown-toggle pr-0" data-toggle="dropdown" aria-expanded="false">
                <img style="border:2.7px solid white;" src="
                @if (auth()->user()->image && file_exists(public_path('uploads/users/' . auth()->user()->image))) {{ asset('uploads/users/' . auth()->user()->image) }}
                @else {{ asset('uploads/default-profile.png') }} @endif" class="user-image img-circle elevation-2 " alt="User Image">
            </a>
            <div class="dropdown-menu dropdown-menu-right p-2 mt-1">
                <div class="form-group p-2 mb-0">
                    <h5>{{ Auth::user()->name }}</h5>
                    <span
                        style="color: rgb(172, 172, 172)">{{ implode(', ', Auth::user()->roles()->pluck('name')->toArray()) }}</span>
                </div>
                <hr class="my-2">
                <a href="{{ route('admin.show_info', auth()->user()->id) }}"
                    class="dropdown-item text-capitalize mb-1">
                    {{ __('Settings') }}
                </a>
                <a href="{{ route('logout') }}" class="dropdown-item text-capitalize">
                    {{ __('Log out') }}
                </a>
            </div>
        </li>
        <li class="nav-item align-content-center pr-3 pl-1">
            <span>{{ __('Hi') }}, <b class="text-capitalize" style="font-weight: 600">{{ Auth::user()->name }}</b></span>
        </li>
        {{-- <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li> --}}
    </ul>
</nav>
