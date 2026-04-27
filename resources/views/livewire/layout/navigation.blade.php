<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component
{
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<nav x-data="{ open: false }" class="bg-slate-900 border-b border-slate-800 shadow-2xl shadow-black/40 sticky top-0 z-50">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10">
        <div class="flex justify-between h-20">
            <div class="flex items-center gap-12">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('products.index') }}" wire:navigate class="transform transition hover:scale-110 duration-500">
                        <x-application-logo class="block h-12 w-auto" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden sm:flex items-center gap-10 h-full">
                    @php
                        $links = [
                            ['route' => 'products.index', 'label' => 'Shop', 'active' => request()->routeIs('products.*')],
                            ['route' => 'wishlist', 'label' => 'Wishlist', 'active' => request()->routeIs('wishlist'), 'id' => 'wishlist'],
                            ['route' => 'orders.index', 'label' => 'Orders', 'active' => request()->routeIs('orders.*')],
                            ['route' => 'cart', 'label' => 'Cart', 'active' => request()->routeIs('cart'), 'id' => 'cart'],
                        ];
                    @endphp

                    @foreach($links as $link)
                        <a href="{{ route($link['route']) }}" 
                           wire:navigate
                           class="relative h-full flex items-center px-2 text-[11px] font-black uppercase tracking-[0.25em] transition-all duration-300
                                  {{ $link['active'] ? 'text-white' : 'text-slate-500 hover:text-slate-300 hover:tracking-[0.35em]' }}">
                            {{ $link['label'] }}
                            
                            @if(isset($link['id']))
                                <span class="nav-{{ $link['id'] }}-count ms-2 bg-orange-600 text-white text-[9px] font-black rounded-full min-w-[18px] h-[18px] flex items-center justify-center px-1 leading-none shadow-lg shadow-orange-600/20"
                                      style="display: none;">0</span>
                            @endif

                            @if($link['active'])
                                <div class="absolute bottom-0 left-0 w-full h-[3px] bg-gradient-to-r from-red-600 to-orange-500 rounded-t-full shadow-lg shadow-orange-600/50"></div>
                            @endif
                        </a>
                    @endforeach

                    @if(auth()->check() && auth()->user()->is_admin)
                        <a href="{{ route('admin.dashboard') }}" 
                           wire:navigate
                           class="h-full flex items-center px-2 text-[11px] font-black uppercase tracking-[0.25em] text-red-500 hover:text-red-400 transition-colors">
                            Admin
                            @if(request()->routeIs('admin.*'))
                                <div class="absolute bottom-0 left-0 w-full h-[3px] bg-red-600 rounded-t-full"></div>
                            @endif
                        </a>
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-4 py-2.5 bg-slate-800 border-2 border-slate-700 text-[10px] font-black uppercase tracking-[0.2em] rounded-2xl text-slate-300 hover:text-white hover:bg-slate-750 hover:border-slate-600 transition-all duration-300 shadow-xl active:scale-95 group">
                            <div class="flex items-center gap-2">
                                <div class="w-2 h-2 rounded-full bg-green-500 shadow-lg shadow-green-500/50 group-hover:animate-ping"></div>
                                <div x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name"></div>
                            </div>

                            <div class="ms-3 transition-transform duration-300 group-hover:translate-y-0.5">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile')" wire:navigate>
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <button wire:click="logout" class="block w-full px-4 py-3 text-start text-xs font-black uppercase tracking-widest text-red-500 hover:text-red-400 hover:bg-slate-700 focus:outline-none focus:bg-slate-700 transition duration-150 ease-in-out italic">
                            {{ __('Terminate Session') }}
                        </button>
                    </x-slot>
                </x-dropdown>
                @else
                <div class="flex items-center gap-6">
                    <a href="{{ route('login') }}" class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] hover:text-white transition-all">Log in</a>
                    <a href="{{ route('register') }}" class="px-8 py-3 bg-gradient-to-r from-red-600 to-orange-500 rounded-2xl text-[10px] font-black text-white uppercase tracking-[0.3em] hover:from-red-500 hover:to-orange-400 transition-all shadow-2xl shadow-red-600/20 active:scale-95">Register</a>
                </div>
                @endauth
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-3 rounded-2xl text-slate-400 hover:text-white hover:bg-slate-800 transition-all border border-slate-700">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div x-show="open" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         class="sm:hidden bg-slate-900 border-t border-slate-800 pb-6">
        <div class="pt-4 space-y-2">
            @foreach($links as $link)
                <x-responsive-nav-link :href="route($link['route'])" :active="$link['active']" wire:navigate>
                    <div class="flex items-center justify-between w-full">
                        <span class="uppercase tracking-widest font-black italic">{{ $link['label'] }}</span>
                        @if(isset($link['id']))
                            <span class="nav-{{ $link['id'] }}-count bg-orange-600 text-white text-[9px] font-black rounded-full min-w-[18px] h-[18px] flex items-center justify-center px-1 leading-none shadow-lg shadow-orange-600/20"
                                  style="display: none;">0</span>
                        @endif
                    </div>
                </x-responsive-nav-link>
            @endforeach
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-6 pb-1 border-t border-slate-800 mx-4 mt-6">
            @auth
            <div class="px-4 flex items-center gap-4 mb-6">
                <div class="w-12 h-12 rounded-2xl bg-slate-800 flex items-center justify-center text-white font-black italic border border-slate-700">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
                <div>
                    <div class="font-black tracking-widest uppercase text-white" x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name"></div>
                    <div class="font-bold text-xs text-slate-500 tracking-tight">{{ auth()->user()->email }}</div>
                </div>
            </div>

            <div class="space-y-1">
                <x-responsive-nav-link :href="route('profile')" wire:navigate>
                    {{ __('Account Settings') }}
                </x-responsive-nav-link>

                <button wire:click="logout" class="block w-full ps-3 pe-4 py-3 border-l-4 border-transparent text-start text-base font-black italic uppercase tracking-widest text-red-500 hover:text-red-400 hover:bg-slate-800 hover:border-red-500 focus:outline-none focus:text-red-400 focus:bg-slate-800 focus:border-red-500 transition duration-150 ease-in-out">
                    {{ __('Terminate Session') }}
                </button>
            </div>
            @else
            <div class="space-y-4 px-4">
                <a href="{{ route('login') }}" class="block w-full py-4 text-center text-xs font-black text-slate-400 uppercase tracking-widest border border-slate-700 rounded-2xl">Log in</a>
                <a href="{{ route('register') }}" class="block w-full py-4 text-center text-xs font-black text-white uppercase tracking-widest bg-gradient-to-r from-red-600 to-orange-500 rounded-2xl shadow-xl shadow-red-600/20">Register</a>
            </div>
            @endauth
        </div>
    </div>
</nav>

<script>
    function updateNavBadges() {
        // Cart
        fetch('/cart-count', {headers:{'X-Requested-With':'XMLHttpRequest'}})
            .then(r => r.ok ? r.json() : null)
            .then(data => {
                if (!data) return;
                document.querySelectorAll('.nav-cart-count').forEach(el => {
                    if (data.count > 0) {
                        el.textContent = data.count;
                        el.style.display = 'flex';
                    } else {
                        el.style.display = 'none';
                    }
                });
            }).catch(() => {});

        // Wishlist
        fetch('/wishlist-count', {headers:{'X-Requested-With':'XMLHttpRequest'}})
            .then(r => r.ok ? r.json() : null)
            .then(data => {
                if (!data) return;
                document.querySelectorAll('.nav-wishlist-count').forEach(el => {
                    if (data.count > 0) {
                        el.textContent = data.count;
                        el.style.display = 'flex';
                    } else {
                        el.style.display = 'none';
                    }
                });
            }).catch(() => {});
    }
    document.addEventListener('DOMContentLoaded', updateNavBadges);
    document.addEventListener('livewire:navigated', updateNavBadges);
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('cartUpdated', updateNavBadges);
        Livewire.on('cart-added', updateNavBadges);
        Livewire.on('wishlist-updated', updateNavBadges);
        Livewire.on('wishlistUpdated', updateNavBadges);
    });
</script>
