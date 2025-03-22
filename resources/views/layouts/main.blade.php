<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>

    {{-- CSS Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    {{-- Material Icons --}}
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    {{-- Fonte Schibsted Grotesk--}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Schibsted+Grotesk:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
    

    <link rel="stylesheet" href="/css/main/index.css">
    <link rel="stylesheet" href="/css/main/navbar.css">
    <link rel="stylesheet" href="/css/components/sidebars.css">
    <script src="/js/components/sidebars.js"></script>


    {{-- ícones da sidebar --}}

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    <style>
        .material-symbols-outlined {
          font-variation-settings:
          'FILL' 0,
          'wght' 200,
          'GRAD' 0,
          'opsz' 24
        }
    </style>
    
    @stack('style')
    @stack('script')
    {{-- importa apenas os links do css e js indicados no 'content' pela diretiva 'push' --}}

</head>
<body>

    <div id="layout-body" class="d-flex justify-content-between">

        <button class="btn btn-dark d-md-none position-fixed top-0 start-0 m-3" data-bs-toggle="offcanvas" data-bs-target="#sidebar">
            <i class="material-symbols-outlined">menu</i>
        </button>

        <header id="sidebar" class="offcanvas-md offcanvas-start d-flex flex-column flex-shrink-0 p-3 text-white bg-dark" style="width: 280px">

            <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">

                <img src="/img/logo.jpeg" alt="SF" style="border-radius: 50%; width: 50px;">
                <span class="fs-4 ms-3">SystemForge</span>
            </a>

            <hr>

            <ul class="nav nav-pills flex-column mb-auto">

                <li class="nav-item">
                    <a href="{{ route('site.dashboard') }}" class="nav-link d-flex {{ request()->routeIs('site.dashboard') ? 'active' : '' }} text-light">
                        <span class="material-symbols-outlined me-2">
                            bar_chart_4_bars
                        </span>Dashboard</a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('finance.index')}}" class="nav-link text-light d-flex {{ (request()->routeIs('finance*') || request()->routeIs('categor*')) ? 'active' : '' }}">
                        <span class="material-symbols-outlined me-2">
                            paid
                        </span>Financeiro</a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('projects.index') }}" class="nav-link d-flex {{ request()->routeIs('project*', 'task*') ? 'active' : '' }} text-light">
                        <span class="material-symbols-outlined me-2">
                            work
                        </span>Projetos</a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('clients.index') }}" class="nav-link d-flex {{ request()->routeIs('client*') ? 'active' : '' }} text-light">
                        <span class="material-symbols-outlined me-2">
                            groups
                        </span>Clientes</a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('users.index') }}" class="nav-link d-flex {{ request()->routeIs('user*') ? 'active' : '' }} text-light">
                    <span class="material-symbols-outlined me-2">
                        account_circle
                    </span>
                    Usuários</a>
                </li>
            </ul>

            <hr>

            @php
                $user = auth()->user();
                $nameParts = explode(' ', trim($user->name)); // Divide o nome em partes
                $initials = strtoupper(substr($nameParts[0], 0, 1)); // Primeira inicial
            
                if (count($nameParts) > 1) {
                    $initials .= strtoupper(substr($nameParts[1], 0, 1)); // Segunda inicial (se houver nome composto)
                }
            @endphp
        
            <div class="dropdown">

                <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" 
                id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2"
                        style="width: 32px; height: 32px; font-weight: bold;">
                        {{ $initials }}
                    </div>
                    {{-- talvez mudar a cor de acordo com o cargo da pessoa --}}
                    <strong>{{ $user->name }}</strong>
                </a>

                <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">

                    @switch($user->type)
                        @case(Auth()->user()->isPartner())
                            <li><a class="dropdown-item" href="{{ route('project.create') }}">Novo projeto</a></li>
                            <li><a class="dropdown-item" href="{{ route('user.create') }}">Novo usuário</a></li>
                            <li><a class="dropdown-item" href="{{ route('expense.create') }}">Nova despesa</a></li>
                            <li><a class="dropdown-item" href="{{ route('receipt.create') }}">Nova receita</a></li>
                            @break
                        @case('consultant')
                            <li><a class="dropdown-item" href="{{ route('project.create') }}">Novo projeto</a></li>
                            @break
                        @case('financier')
                            <li><a class="dropdown-item" href="{{ route('expense.create') }}">Nova despesa</a></li>
                            <li><a class="dropdown-item" href="{{ route('receipt.create') }}">Nova receita</a></li>
                            @break
                        @default
                            
                    @endswitch

                    <li><hr class="dropdown-divider"></li>

                    <li>
                        <form action="/logout" method="POST">
                            @csrf
                            <a href="/logout" 
                                class="dropdown-item" 
                                onclick="event.preventDefault();this.closest('form').submit();">Sair</a>
                        </form>
                    </li>

                </ul>

            </div>
    
        </header>

        <main class="container p-0 me-0">

            <div class="m-0">
                @if(session('msg'))
                    <p class="msg"> {{ session('msg') }}</p>
                @endif
            </div>

            <div class="content pt-4 px-5 d-flex flex-column justify-content-center">
                @yield('content')
            </div>

        </main>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="/js/components/sidebars.js"></script>
</body>
</html>