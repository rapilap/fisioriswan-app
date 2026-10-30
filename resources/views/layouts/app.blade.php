<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>@yield('title', 'Fisio Riswan')</title>
</head>

<body>
    @include('components.header_navbar')

    <main class="flex flex-col w-full min-h-screen bg-(--bg-primary) @yield('main_class', 'py-20')">
        @include('sweetalert2::index')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        @yield('content')
        @stack('scripts')
    </main>

    @include('components.footer_navbar')
</body>

</html>
