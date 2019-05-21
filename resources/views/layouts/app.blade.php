<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body class="theme-light bg-page">
    <div id="app">
        <nav class="navbar navbar-expand-md bg-nav shadow-sm">
            <div class="container mx-auto">
                <div class="flex justify-between items-center py-2 text-default">
                    <a class="navbar-brand text-4xl" style="font-family: 'Concert One', cursive" href="{{ url('/') }}">
                        {{ config('app.name', 'Board') }}
                    </a>

                    <div>
                        <!-- Right Side Of Navbar -->
                        <div class="flex items-center ml-auto">
                            <!-- Authentication Links -->
                            @guest
                                <a class="mr-2" href="{{ route('login') }}">{{ __('Login') }}</a>
                            @if (Route::has('register'))
                                <a class="ml-2" href="{{ route('register') }}">{{ __('Register') }}</a>
                            @endif
                            @else
                                <theme-switcher></theme-switcher>

                                <dropdown align="right" width="200px">
                                    <template v-slot:trigger>
                                        <button
                                            class="flex items-center text-default text-sm focus:outline-none">  

                                            <img width="35" class="rounded-full mr-3" src="{{ gravatar_url(auth()->user()->email) }}" alt="">
                                            
                                            {{auth()->user()->name}}
                                        </button>
                                    </template>

                                    
                                    <form action="/logout" id="logout-form" method="POST">
                                        @csrf

                                        <button href="" class="block text-default hover:underline text-sm leading-loose px-4 hover:bg-card w-full text-left">Logout</button>

                                    </form>

                                </dropdown>

                                
                            @endguest
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <main class="container mx-auto py-4">
            @yield('content')
        </main>
    </div>
</body>

</html>
