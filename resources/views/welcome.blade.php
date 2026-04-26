<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'ChainX') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,600,800,900&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased font-['Inter'] bg-slate-900 text-white min-h-screen flex flex-col overflow-hidden relative">

    <!-- Decorative background blobs -->
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0 pointer-events-none">
        <div class="absolute -top-40 -left-20 w-96 h-96 bg-red-600 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob"></div>
        <div class="absolute top-1/4 -right-20 w-96 h-96 bg-orange-500 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>
        <div class="absolute -bottom-40 left-1/3 w-96 h-96 bg-red-800 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-4000"></div>
    </div>

    <!-- Header / Navbar -->
    <header class="relative z-10 w-full max-w-7xl mx-auto px-6 py-8 flex justify-between items-center">
        <div>
            <x-application-logo class="h-10 w-auto" />
        </div>
        
        @if (Route::has('login'))
            <nav class="flex space-x-6 items-center">
                <a href="{{ route('products.index') }}" class="font-bold uppercase tracking-widest text-sm text-slate-300 hover:text-white transition">Shop Now</a>
                @auth
                    <a href="{{ route('orders.index') }}" class="px-5 py-2.5 rounded-xl bg-slate-800 border border-slate-700 font-bold uppercase tracking-widest text-xs hover:bg-slate-700 transition">My Orders</a>
                @else
                    <div class="flex items-center space-x-4 border-l border-slate-700 pl-6">
                        <a href="{{ route('login') }}" class="font-bold uppercase tracking-widest text-sm text-slate-300 hover:text-white transition">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-red-600 to-orange-500 font-bold uppercase tracking-widest text-xs hover:from-red-500 hover:to-orange-400 shadow-lg shadow-red-500/20 transition transform hover:-translate-y-0.5">Register</a>
                        @endif
                    </div>
                @endauth
            </nav>
        @endif
    </header>

    <!-- Main Hero Content -->
    <main class="relative z-10 flex-grow flex flex-col items-center justify-center px-6 text-center">
        <h1 class="text-6xl md:text-8xl font-black uppercase tracking-tighter leading-none mb-6">
            Ride <span class="text-transparent bg-clip-text bg-gradient-to-tr from-red-600 to-orange-500">Beyond</span><br />Limits.
        </h1>
        
        <p class="mt-4 text-lg md:text-xl text-slate-400 max-w-2xl mx-auto font-medium">
            Welcome to ChainX. The ultimate premier e-commerce platform for high-performance bicycles, gear, and elite components. Gear up for your next adventure.
        </p>
        
        <div class="mt-10 flex flex-col sm:flex-row gap-4 justify-center items-center">
            <a href="{{ route('products.index') }}" class="px-8 py-4 bg-white text-slate-900 rounded-xl font-black uppercase tracking-widest text-sm hover:bg-slate-200 transition transform hover:scale-105 shadow-2xl">
                Start Shopping
            </a>
            
            @guest
                <a href="{{ route('login') }}" class="px-8 py-4 bg-slate-800 border border-slate-700 text-white rounded-xl font-black uppercase tracking-widest text-sm hover:bg-slate-700 transition transform hover:scale-105 inline-flex items-center group">
                    Sign In to Account
                    <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
            @endguest
        </div>
    </main>

    <footer class="relative z-10 py-6 text-center text-slate-600 text-xs font-bold uppercase tracking-widest border-t border-slate-800/50 mt-auto">
        &copy; {{ date('Y') }} ChainX E-Commerce. Built for Champions.
    </footer>
    
</body>
</html>
