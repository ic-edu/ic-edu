<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('assets/icidu_logo.png') }}">
    <title>Welcome to iC.Edu</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <style>
        *, *::before, *::after { box-sizing: border-box; }
        body { margin: 0; font-family: 'DM Sans', ui-sans-serif, system-ui, sans-serif; background: #f0f4f8; }
        h1, h2, h3 { font-family: 'Poppins', ui-sans-serif, system-ui, sans-serif; }
    </style>
</head>
<body>
    {{ $slot }}
    @livewireScripts
</body>
</html>
