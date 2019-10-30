<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>

    <v-app id="app">

        <v-sheet class="overflow-hidden" style="position:relative;height:100%;" tile>            

            {{-- Admin App --}}

            @can('accessAdmin', App\User::class)

                @include('admin.admin-app')

            @endcan        

            {{-- Customer App --}}

            @cannot('accessAdmin', App\User::class)

                @include('customer-nav')            
    
                <main class="py-4">
    
                    @yield('content')
    
                </main>        
    
            @endcannot
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>

        </v-sheet>

    </v-app>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    @yield('scripts')
</body>
</html>
