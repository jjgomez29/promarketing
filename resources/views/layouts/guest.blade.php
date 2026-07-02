<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0"
             style="background: linear-gradient(135deg, #003f7f 0%, #0077c2 50%, #00aaff 100%);">

            <div class="flex flex-col items-center mb-2">
                <a href="/" class="flex flex-col items-center group">
                    <x-application-logo class="w-16 h-16" style="fill: #ffffff;" />
                    <div class="mt-3 text-center">
                        <span class="text-white font-bold text-3xl tracking-tight">
                            <span style="color:#00ccff;">Pro</span>marketing
                        </span>
                        <p class="text-blue-200 text-xs tracking-widest uppercase mt-0.5">Diseño Web &amp; Gráfico Audiovisual</p>
                    </div>
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-4 px-6 py-6 bg-white shadow-2xl overflow-hidden sm:rounded-xl border-t-4" style="border-color: #0077c2;">
                {{ $slot }}
            </div>

            <p class="mt-6 text-blue-200 text-xs">&copy; {{ date('Y') }} Promarketing. Todos los derechos reservados.</p>
        </div>
    </body>
</html>
