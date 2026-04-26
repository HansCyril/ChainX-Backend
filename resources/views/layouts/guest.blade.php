<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'ChainX') }}</title>

        <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800,900&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-['Inter'] text-gray-900 antialiased bg-slate-900 min-h-screen">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 relative overflow-hidden">
            <!-- Decorative Background Elements -->
            <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0 pointer-events-none">
                <div class="absolute -top-40 -right-40 w-[30rem] h-[30rem] bg-red-600/30 rounded-full mix-blend-screen filter blur-[120px] animate-pulse"></div>
                <div class="absolute -bottom-40 -left-40 w-[30rem] h-[30rem] bg-orange-500/30 rounded-full mix-blend-screen filter blur-[120px] animate-pulse animation-delay-2000"></div>
                <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[40rem] h-[40rem] bg-indigo-900/20 rounded-full mix-blend-overlay filter blur-[150px]"></div>
            </div>

            <div class="z-10 w-full sm:max-w-md">
                <div class="flex justify-center mb-10">
                    <a href="/" wire:navigate class="transition-all hover:scale-110 duration-500 hover:drop-shadow-[0_0_25px_rgba(239,68,68,0.5)]">
                        <x-application-mark class="w-28 h-28" />
                    </a>
                </div>

                <div class="w-full bg-slate-800/40 backdrop-blur-3xl border border-white/10 shadow-[0_20px_50px_rgba(0,0,0,0.5)] overflow-hidden sm:rounded-[2.5rem] p-10 relative">
                    <!-- Subtle inner glow -->
                    <div class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-white/20 to-transparent"></div>
                    {{ $slot }}
                </div>
            </div>
            
            <div class="mt-8 text-center text-sm z-10 text-slate-500">
                &copy; {{ date('Y') }} ChainX Bicycle Co.
            </div>
        </div>
    </body>
</html>
