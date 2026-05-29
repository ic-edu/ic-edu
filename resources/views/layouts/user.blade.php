<!DOCTYPE html>
{{-- data-theme diset oleh JS di navbar sebelum body render penuh --}}
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('assets/icidu_logo.png') }}">

    <title>@yield('title', config('app.name', 'IC.EDU')) — Master English, Master the World</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Vite Assets (app.css sudah @import theme.css di dalamnya) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{--
        Anti Flash-of-Wrong-Theme (FOWT):
        Script kecil ini membaca localStorage dan menerapkan
        data-theme ke <html> SEBELUM CSS selesai render,
        sehingga tidak ada kedipan putih/gelap saat load.
    --}}
    <script>
        (function() {
            var saved = localStorage.getItem('icedu_theme');
            if (saved === 'dark') {
                document.documentElement.setAttribute('data-theme', 'dark');
            } else if (!saved) {
                // Fallback: ikuti system preference
                if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
                    document.documentElement.setAttribute('data-theme', 'dark');
                }
            }
        })();
    </script>

    {{-- Per-page styles --}}
    @stack('styles')
</head>

{{-- bg-white di-override oleh body { background-color: var(--bg-page) } di theme.css --}}
<body class="overflow-x-hidden antialiased" style="font-family: 'Plus Jakarta Sans', sans-serif;">

    {{-- Navbar (sudah include theme toggle + script) --}}
    @include('components.navbar')

    {{-- Page Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('components.footer')

    {{-- Scroll reveal --}}
    <script>
        const revealObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity   = '1';
                    entry.target.style.transform = 'translateY(0)';
                    revealObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('[data-reveal]').forEach(el => {
            el.style.opacity   = '0';
            el.style.transform = 'translateY(28px)';
            el.style.transition = 'opacity 0.65s ease, transform 0.65s ease';
            revealObserver.observe(el);
        });
    </script>

    @stack('scripts')

</body>
</html>