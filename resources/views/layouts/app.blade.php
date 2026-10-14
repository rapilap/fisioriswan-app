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

    <main class="flex flex-col pt-8 w-full min-h-screen bg-[#f5f5f5]">
        @yield('content')
    </main>

    @include('components.footer_navbar')
</body>

</html>
