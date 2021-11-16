<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }} | @yield('title')</title>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    
    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- Fontawesome !-->
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
</head>
<body>
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand mt-2" href="{{ url('/') }}">
                <h5>{{ config('app.name') }}</h5>
            </a>

            <div class="collapse navbar-collapse">
                <!-- Left Side Of Navbar -->
                <div class="collapse navbar-collapse justify-content-center">
                    @auth
                        @if(!request()->is('admin/*'))
                        <form class="row align-items-center" action="{{ route('index') }}" style="width:35%;">
                            <div class="input-group">
                                <input name="search" type="text" class="form-control form-control-sm" placeholder="Search" value="{{ $search ?? '' }}" />
                                <button type="submit" class="btn btn-secondary btn-sm"><i class="fas fa-search"></i></button>
                            </div>
                        </form>
                        @endif
                    @endauth
                </div>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto d-flex">
                    <!-- Authentication Links -->
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif

                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else

                        <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Home Screen">
                            <a class="nav-link" href="{{ route('index') }}"><i class="fas fa-home fa-2x"></i></a>
                        </li> <!-- home !-->
                        <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Create Post">
                            <a class="nav-link" href="{{ route('post.create') }}"><i class="fas fa-plus-square fa-2x"></i></a>
                        </li> <!-- post create !-->
                        
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                @if (Auth::user()->avatar)
                                <img src="{{ App\Models\User::showAvatar(Auth::user()->avatar) }}" class="rounded border border-1 rounded-circle" style="height: 2.1rem; width: 2.18rem; "/> 
                                @else
                                <i class="far fa-user-circle fa-2x"></i>
                                @endif
                            </a>
                            <ul class="dropdown-menu dropdown-menu dropdown-menu-lg-end" aria-labelledby="navbarDarkDropdownMenuLink">
                                @if (Auth::user()->role_id === App\Models\User::ADMIN_ROLE_ID)
                                <li><a class="dropdown-item" href="{{ route('admin.index') }}"><i class="fas fa-user-cog"></i> Admin</a></li>
                                <li><hr class="dropdown-divider"></li>
                                @endif
                                <li>
                                    <a class="dropdown-item" href="{{ route('profile.show', Auth::user()->id) }}">
                                        <i class="far fa-user-circle"></i> Profile
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt"></i> {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        <div class="container">
            <div class="row justify-content-center">
                @can('admin')
                    @if (request()->is('admin') || request()->is('admin/*'))
                    <div class="col-2">
                        <div class="list-group">
                            <a href="{{ route('admin.index') }}" class="list-group-item list-group-item-action {{ request()->is('admin') ? 'active' : '' }}" aria-current="true">
                                <i class="fas fa-users"></i> Users
                            </a>

                            <a href="{{ route('admin.posts.index') }}" class="list-group-item list-group-item-action {{ request()->is('admin/posts') ? 'active' : '' }}" aria-current="true">
                                <i class="far fa-newspaper"></i> Posts
                            </a>

                            <a href="{{ route('admin.categories.index') }}" class="list-group-item list-group-item-action {{ request()->is('admin/categories') ? 'active' : '' }}" aria-current="true">
                                <i class="fas fa-tags"></i> Categories
                            </a>
                        </div>
                    </div>
                    @endif
                @endcan
                <div class="col-10">
                    @yield('content')
                </div>
            </div>
        </div>
    </main>
</body>
</html>
