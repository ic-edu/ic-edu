<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Examiner Portal - {{ config('app.name', 'IC-EDU') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@100..1000&family=Poppins:wght@100..900&display=swap"
        rel="stylesheet">

    @vite([
    'resources/css/app.css',
    'resources/css/test_taker.css',
    'resources/js/app.js'
    ])
</head>

<body>

    <div class="dash-shell">

        {{-- SIDEBAR --}}
        @include('components.examiner.sidebar')

        <div class="dash-main">

            {{-- TOPBAR --}}
            @include('components.test_taker.topbar')

            <div class="page-body">


                @yield('content')

                {{ $slot ?? '' }}
            </div>

        </div>

    </div>

</body>

</html>