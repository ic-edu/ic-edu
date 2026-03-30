<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Student Portal') - {{ config('app.name', 'IC-EDU') }}</title>
    @vite(['resources/css/app.css', 'resources/css/test_taker.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body>
    <div class="dash-shell">
        @include('components.test_taker.sidebar')
        <div class="dash-main">
            @include('components.test_taker.topbar')
            <div class="page-body">
                @yield('content')
                {{ $slot ?? '' }}
            </div>
        </div>
    </div>
    @stack('scripts')
</body>
</html>
