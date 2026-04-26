<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        if (auth()->user()->is_admin) {
            $this->redirectIntended(default: route('admin.dashboard', absolute: false), navigate: true);
        } else {
            $this->redirectIntended(default: route('products.index', absolute: false), navigate: true);
        }
    }
}; ?>

<div class="text-white">
    <!-- Header -->
    <div class="text-center mb-10">
        <h2 class="text-4xl font-black uppercase tracking-tighter text-white mb-2 drop-shadow-sm">Sign In</h2>
        <div class="h-1.5 w-12 bg-gradient-to-r from-red-600 to-orange-500 mx-auto rounded-full mb-4"></div>
        <p class="text-sm font-bold text-slate-400">Unlock your elite performance account</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-6 p-4 rounded-xl bg-orange-500/10 text-orange-400 border border-orange-500/20" :status="session('status')" />

    <form wire:submit="login" class="space-y-6">
        <!-- Email Address -->
        <div>
            <label for="email" class="block text-[10px] font-black uppercase tracking-[0.2em] text-slate-500 mb-2 ml-1">Account Email</label>
            <div class="relative group">
                <input wire:model="form.email" id="email" class="block w-full rounded-2xl bg-slate-900/50 border-white/5 text-white shadow-2xl focus:border-red-500/50 focus:ring-red-500/20 focus:ring-4 transition-all duration-300 placeholder:text-slate-700 px-5 py-4" type="email" name="email" placeholder="you@chainx-pro.com" required autofocus autocomplete="username" />
                <div class="absolute inset-0 rounded-2xl border border-white/5 pointer-events-none group-hover:border-red-500/20 transition-colors"></div>
            </div>
            <x-input-error :messages="$errors->get('form.email')" class="mt-2 text-xs font-bold text-red-500 italic ml-1" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex justify-between items-center mb-2 px-1">
                <label for="password" class="block text-[10px] font-black uppercase tracking-[0.2em] text-slate-500">Secure Password</label>
                @if (Route::has('password.request'))
                    <a class="text-[10px] font-black uppercase tracking-widest text-red-500 hover:text-red-400 transition-all hover:tracking-[0.25em]" href="{{ route('password.request') }}" wire:navigate>
                        Recovery?
                    </a>
                @endif
            </div>

            <div class="relative group">
                <input wire:model="form.password" id="password" class="block w-full rounded-2xl bg-slate-900/50 border-white/5 text-white shadow-2xl focus:border-red-500/50 focus:ring-red-500/20 focus:ring-4 transition-all duration-300 placeholder:text-slate-700 px-5 py-4" type="password" name="password" placeholder="••••••••" required autocomplete="current-password" />
                <div class="absolute inset-0 rounded-2xl border border-white/5 pointer-events-none group-hover:border-red-500/20 transition-colors"></div>
            </div>
            <x-input-error :messages="$errors->get('form.password')" class="mt-2 text-xs font-bold text-red-500 italic ml-1" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <input wire:model="form.remember" id="remember" type="checkbox" class="w-5 h-5 rounded border-slate-700 bg-slate-900 text-red-600 shadow-sm focus:ring-red-500 focus:ring-offset-slate-800 transition-colors cursor-pointer" name="remember">
            <label for="remember" class="ms-3 text-sm font-medium text-slate-300 cursor-pointer select-none">Remember my device</label>
        </div>

        <div class="pt-6">
            <button type="submit" class="w-full flex justify-center items-center px-8 py-5 bg-gradient-to-r from-red-600 via-orange-500 to-red-600 bg-[length:200%_auto] border border-white/10 rounded-2xl font-black text-xs text-white uppercase tracking-[0.3em] hover:bg-right transition-all duration-500 shadow-[0_15px_40px_rgba(220,38,38,0.4)] transform hover:-translate-y-1.5 active:scale-95 group">
                Authorize Access
                <svg class="ml-3 w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </button>
        </div>
        
        <div class="text-center mt-6">
            <p class="text-sm font-medium text-slate-400">
                Don't have an account? 
                <a href="{{ route('register') }}" class="font-bold text-white hover:text-orange-400 transition-colors" wire:navigate>Sign up</a>
            </p>
        </div>
    </form>
</div>
