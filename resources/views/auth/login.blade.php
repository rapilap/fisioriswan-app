<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin | Ermaya Physio</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-gray-100 flex items-center justify-center px-4">

    <main class="w-full max-w-xl h-100 rounded-2xl bg-white shadow-lg flex flex-row">
        <div class="w-full bg-b1 rounded-2xl text-white p-6">
            <div class="flex h-full flex-col items-start justify-center gap-3">
                <div class="flex justify-center items-center gap-3">
                    <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-white text-b1">
                        @include('components.icon', ['name' => 'home', 'class' => 'w-[18px] h-[18px]'])
                    </span>

                    <h1 class="font-fraunces text-xl font-bold">
                        Ermaya Physio
                    </h1>
                </div>

                <h1 class="font-fraunces text-md font-bold">
                    Selamat Datang Kembali!
                </h1>

                <p class="mt-2 text-sm text-white/80">
                    Silahkan login untuk mengakses panel admin.
                </p>
            </div>
        </div>

        <div class="w-full h-full p-6 flex items-center justify-center flex-col">
            <div class="mb-8 text-center">
                <h1 class="font-fraunces text-md font-bold text-gray-900">
                    Sign In Admin Ermaya Physio
                </h1>
                <p class="mt-2 text-xs text-gray-500">
                    Login menggunakan email dan password Anda.
                </p>
            </div>

            @if ($errors->any())
                <div class="mb-5 rounded-lg bg-red-50 p-3 text-sm text-red-700">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-5">
                @csrf

                <div class="w-full flex flex-row items-center gap-1 px-1 rounded-lg  bg-white">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24"
                        class="text-gray-400">
                        <path d="M0 0h24v24H0z" fill="none" />
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="1"
                            d="m4 6l6.108 4.612l.002.002c.678.497 1.017.746 1.389.842a2 2 0 0 0 1.002 0c.372-.096.712-.345 1.392-.844c0 0 3.917-3.006 6.107-4.612M3 15.8V8.2c0-1.12 0-1.68.218-2.108c.192-.377.497-.682.874-.874C4.52 5 5.08 5 6.2 5h11.6c1.12 0 1.68 0 2.107.218c.377.192.683.497.875.874c.218.427.218.987.218 2.105v7.607c0 1.118 0 1.676-.218 2.104a2 2 0 0 1-.875.874c-.427.218-.986.218-2.104.218H6.197c-1.118 0-1.678 0-2.105-.218a2 2 0 0 1-.874-.874C3 17.48 3 16.92 3 15.8" />
                    </svg>

                    <input id="email" type="email" name="email" value="{{ old('email') }}"
                        autocomplete="username" required autofocus
                        class="w-full px-2 py-1 border-b border-gray-200 
                           outline-none focus:border-gray-400 text-sm"
                        placeholder="Email">
                </div>

                <div class="w-full flex flex-row items-center gap-1 px-1 rounded-lg  bg-white">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 48 48"
                        class="text-gray-600">
                        <path d="M0 0h48v48H0z" fill="none" />
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            d="M24 25.28a3.26 3.26 0 0 0-1.64 6.07V36h3.32v-4.65a3.28 3.28 0 0 0 1.61-2.8A3.27 3.27 0 0 0 24 25.28" />
                        <rect width="33.23" height="25.73" x="7.38" y="17.77" fill="none" stroke="currentColor"
                            stroke-linecap="round" stroke-linejoin="round" rx="4.32" />
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            d="M13.35 17.77v-2.61a10.66 10.66 0 0 1 21.32 0v2.61" />
                    </svg>

                    <input id="password" type="password" name="password" autocomplete="current-password" required
                        class="w-full px-2 py-1 border-b border-gray-200 
                           outline-none focus:border-gray-400 text-sm"
                        placeholder="Password">
                </div>

                <button type="submit"
                    class="w-full rounded-lg bg-b1 px-4 py-3
                       font-semibold text-white transition hover:bg-b2 cursor-pointer">
                    SIGN IN
                </button>
            </form>
        </div>

    </main>

</body>

</html>
