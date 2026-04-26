<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered($user = User::create($validated)));

        Auth::login($user);

        $this->redirect(route('products.index', absolute: false), navigate: true);
    }
}; ?>

<div class="text-white">
    <!-- Header -->
    <div class="text-center mb-8">
        <h2 class="text-3xl font-black uppercase tracking-tight text-white">Create Account</h2>
        <p class="text-sm font-medium text-slate-400 mt-2">Join ChainX and gear up for your next adventure</p>
    </div>

    <form wire:submit="register" class="space-y-6">
        <!-- Name -->
        <div>
            <label for="name" class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-2">Full Name</label>
            <input wire:model="name" id="name" class="block w-full rounded-xl bg-slate-900 border-slate-700 text-white shadow-inner focus:border-red-500 focus:ring-red-500 focus:ring-offset-0 focus:ring-1 transition-all placeholder:text-slate-600 px-4 py-3" type="text" name="name" placeholder="John Doe" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-500" />
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-2">Email Address</label>
            <input wire:model="email" id="email" class="block w-full rounded-xl bg-slate-900 border-slate-700 text-white shadow-inner focus:border-red-500 focus:ring-red-500 focus:ring-offset-0 focus:ring-1 transition-all placeholder:text-slate-600 px-4 py-3" type="email" name="email" placeholder="you@example.com" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-2">Password</label>
            <input wire:model="password" id="password" class="block w-full rounded-xl bg-slate-900 border-slate-700 text-white shadow-inner focus:border-red-500 focus:ring-red-500 focus:ring-offset-0 focus:ring-1 transition-all placeholder:text-slate-600 px-4 py-3" type="password" name="password" placeholder="••••••••" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-2">Confirm Password</label>
            <input wire:model="password_confirmation" id="password_confirmation" class="block w-full rounded-xl bg-slate-900 border-slate-700 text-white shadow-inner focus:border-red-500 focus:ring-red-500 focus:ring-offset-0 focus:ring-1 transition-all placeholder:text-slate-600 px-4 py-3" type="password" name="password_confirmation" placeholder="••••••••" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-500" />
        </div>

        <div class="pt-4">
            <button type="submit" class="w-full flex justify-center items-center px-6 py-4 bg-gradient-to-r from-red-600 to-orange-500 border border-transparent rounded-xl font-black text-sm text-white uppercase tracking-widest hover:from-red-500 hover:to-orange-400 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 focus:ring-offset-slate-900 transition-all shadow-lg shadow-red-500/30 transform hover:-translate-y-1">
                Create Account
                <svg class="ml-2 w-5 h-5 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
            </button>
        </div>

        <div class="text-center mt-6 flex flex-col space-y-2">
            <p class="text-sm font-medium text-slate-400">
                Already registered? 
                <a class="font-bold text-white hover:text-orange-400 transition-colors" href="{{ route('login') }}" wire:navigate>
                    Log In
                </a>
            </p>
        </div>
    </form>
</div>
