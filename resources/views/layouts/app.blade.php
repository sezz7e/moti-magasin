<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Moti Atelier' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-ivory text-ink font-sans antialiased">
    <header class="flex items-center justify-between px-6 md:px-12 py-6 border-b border-ink/10">
        <a href="{{ route('home') }}" class="font-serif text-2xl tracking-[0.2em] uppercase">Moti Atelier</a>
        <nav class="text-sm tracking-wide space-x-6">
            <a href="{{ route('home') }}#collections" class="hover:text-gold">Collections</a>
        </nav>
    </header>

    <main>@yield('content')</main>

    <footer class="px-6 md:px-12 py-10 mt-24 border-t border-ink/10 text-sm text-ink/60">
        &copy; {{ date('Y') }} Moti Atelier. Handmade with love.
    </footer>
</body>
</html>