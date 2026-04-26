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
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            <livewire:layout.navigation />

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
        <!-- Cart Toast Notification -->
        <div id="cart-toast-container" class="fixed top-6 right-6 z-[9999] flex flex-col gap-3 pointer-events-none"></div>

        <style>
            @keyframes toast-in {
                from { opacity: 0; transform: translateX(110%) scale(0.95); }
                to   { opacity: 1; transform: translateX(0)   scale(1); }
            }
            @keyframes toast-out {
                from { opacity: 1; transform: translateX(0)   scale(1); }
                to   { opacity: 0; transform: translateX(110%) scale(0.95); }
            }
            .cart-toast { animation: toast-in 0.4s cubic-bezier(0.34,1.56,0.64,1) forwards; }
            .cart-toast.removing { animation: toast-out 0.3s ease-in forwards; }
        </style>

        <script>
            document.addEventListener('livewire:initialized', () => {
                Livewire.on('cart-added', (event) => {
                    const data = event[0] || event;
                    const name  = data.name  ?? 'Item';
                    const image = data.image ?? '';
                    showCartToast(name, image);
                });

                Livewire.on('show-toast', (event) => {
                    const data = event[0] || event;
                    showSimpleToast(data.message, data.type || 'info');
                });
            });

            function showSimpleToast(message, type) {
                const container = document.getElementById('cart-toast-container');
                const toast = document.createElement('div');
                toast.className = `cart-toast pointer-events-auto flex items-center gap-4 border rounded-2xl shadow-2xl px-5 py-4 min-w-[320px] max-w-sm ${type === 'error' ? 'bg-red-50 border-red-200 shadow-red-200/50' : 'bg-white border-gray-100 shadow-gray-200/60'}`;
                
                toast.innerHTML = `
                    <div class="flex-shrink-0 w-10 h-10 rounded-xl flex items-center justify-center ${type === 'error' ? 'bg-red-500 text-white' : 'bg-indigo-600 text-white'} shadow-lg transform -rotate-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="${type === 'error' ? 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z' : 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'}"></path>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-[11px] font-black uppercase tracking-[0.15em] mb-0.5 ${type === 'error' ? 'text-red-600' : 'text-indigo-600'} italic">${type === 'error' ? 'Alert' : 'Notice'}</p>
                        <p class="text-sm font-bold text-gray-900 leading-tight">${message}</p>
                    </div>
                `;
                container.appendChild(toast);
                setTimeout(() => dismissToast(toast), 3400);
            }

            function showCartToast(name, image) {
                const container = document.getElementById('cart-toast-container');

                const toast = document.createElement('div');
                toast.className = 'cart-toast pointer-events-auto flex items-center gap-4 bg-white border border-gray-100 rounded-2xl shadow-2xl shadow-gray-200/60 px-5 py-4 min-w-[320px] max-w-sm';
                toast.innerHTML = `
                    <div class="relative flex-shrink-0">
                        <img src="${image}" alt="${name}" class="w-14 h-14 rounded-xl object-contain bg-gray-50 p-1 border border-gray-100">
                        <span class="absolute -top-2 -right-2 bg-indigo-600 text-white rounded-full w-6 h-6 flex items-center justify-center shadow-lg">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                        </span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-[11px] font-black text-indigo-600 uppercase tracking-[0.15em] mb-0.5">Added to Cart!</p>
                        <p class="text-sm font-bold text-gray-900 truncate">${name}</p>
                    </div>
                    <button onclick="dismissToast(this.closest('.cart-toast'))" class="ml-1 text-gray-300 hover:text-gray-500 transition-colors flex-shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                `;

                // Progress bar element
                const bar = document.createElement('div');
                bar.style.cssText = 'position:absolute;bottom:0;left:0;height:3px;width:100%;background:linear-gradient(90deg,#6366f1,#818cf8);border-radius:0 0 1rem 1rem;transition:width 3s linear;';
                toast.style.position = 'relative';
                toast.style.overflow = 'hidden';
                toast.appendChild(bar);

                container.appendChild(toast);
                // Start progress bar
                requestAnimationFrame(() => { requestAnimationFrame(() => { bar.style.width = '0%'; }); });

                // Auto-dismiss after 3.4s
                const timer = setTimeout(() => dismissToast(toast), 3400);
                toast._timer = timer;
            }

            function dismissToast(toast) {
                if (!toast || toast.classList.contains('removing')) return;
                clearTimeout(toast._timer);
                toast.classList.add('removing');
                toast.addEventListener('animationend', () => toast.remove(), { once: true });
            }
        </script>
    </body>
</html>
