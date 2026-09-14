<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Közigazgatás</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&family=Quicksand&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('style.css')}}">
    <link rel="shortcut icon" href="{{asset('favicon.ico')}}" type="image/x-icon">
</head>
<body>
    <header>
        <img src="{{asset('logo.png')}}" alt="logo">
        <nav>
            <ul>
                <li><a href="{{route('cities.index')}}">Városok</a></li>
                <li><a href="{{route('counties.index')}}">Megyék</a></li>
            </ul>
        </nav>
    </header>
    <main>
        @yield('content')
    </main>
    <footer>
        <p>© 2026 Közigazgatás - Selmeczy György</p>
    </footer>
    <script src="{{ asset('js/script.js') }}" defer></script>
</body>
</html>