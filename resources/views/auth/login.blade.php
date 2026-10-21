<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin | Ermaya Physio</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-gray-50 flex items-center justify-center px-4">

    <main class="w-full max-w-md rounded-2xl bg-white p-8 shadow-lg">
        <div class="mb-8 text-center">
            <h1 class="text-2xl font-bold text-gray-900">
                Ermaya Physio
            </h1>
            <p class="mt-2 text-sm text-gray-500">
                Login untuk mengakses panel admin
            </p>
        </div>

        @if ($errors->any())
            <div class="mb-5 rounded-lg bg-red-50 p-3 text-sm text-red-700">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label for="email" class="mb-2 block text-sm font-medium text-gray-700">
                    Email
                </label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" autocomplete="username"
                    required autofocus
                    class="w-full rounded-lg border border-gray-300 px-4 py-3
                           outline-none focus:border-blue-600 focus:ring-2
                           focus:ring-blue-100">
            </div>

            <div>
                <label for="password" class="mb-2 block text-sm font-medium text-gray-700">
                    Password
                </label>
                <input id="password" type="password" name="password" autocomplete="current-password" required
                    class="w-full rounded-lg border border-gray-300 px-4 py-3
                           outline-none focus:border-blue-600 focus:ring-2
                           focus:ring-blue-100">
            </div>

            <button type="submit"
                class="w-full rounded-lg bg-blue-700 px-4 py-3
                       font-semibold text-white transition hover:bg-blue-800">
                Login
            </button>
        </form>
    </main>

</body>

</html>
