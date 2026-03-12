<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'IC.EDU')) — Master English, Master the World</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Vite Assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Extra head styles per page --}}
    @stack('styles')
</head>
<body class="bg-white text-slate-900 overflow-x-hidden antialiased" style="font-family: 'Plus Jakarta Sans', sans-serif;">

    {{-- ── Navbar ── --}}
    @include('components.navbar')

    {{-- ── Page Content ── --}}
    <main>
        @yield('content')
    </main>

    {{-- ── Footer ── --}}
    @include('components.footer')

    {{-- Scroll reveal --}}
    <script>
        const revealObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity    = '1';
                    entry.target.style.transform  = 'translateY(0)';
                    revealObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('[data-reveal]').forEach(el => {
            el.style.opacity    = '0';
            el.style.transform  = 'translateY(28px)';
            el.style.transition = 'opacity 0.65s ease, transform 0.65s ease';
            revealObserver.observe(el);
        });
    </script>

    {{-- Extra scripts per page --}}
    @stack('scripts')

</body>
</html>