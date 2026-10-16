<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>@yield('title', 'Admin - Pulihkan')</title>
</head>

<body class="bg-sage font-sans text-primary">
    <x-admin-navbar />

    <main class="mx-auto min-h-screen w-full max-w-6xl px-6 py-10">
        @yield('content')
    </main>
</body>

</html>
