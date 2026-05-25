<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="mb-6 text-center">
        <h2 class="text-lg font-bold text-white leading-tight">Welcome back</h2>
        <p class="text-xs text-slate-500 mt-1">Please enter your credentials to enter the AI portal.</p>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email Address')" />
            <x-text-input id="email" class="block mt-1 w-full text-xs" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="name@domain.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full text-xs"
                            type="password"
                            name="password"
                            required autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between mt-4">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded bg-slate-950 border-slate-800 text-purple-500 shadow-sm focus:ring-purple-500/20 focus:ring-offset-slate-900 focus:outline-none" name="remember">
                <span class="ms-2 text-xs text-slate-400 font-semibold select-none">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-xs text-slate-400 hover:text-white transition-colors" href="{{ route('password.request') }}">
                    {{ __('Forgot password?') }}
                </a>
            @endif
        </div>

        <div class="mt-6 flex flex-col gap-3">
            <x-primary-button class="w-full py-3">
                {{ __('Log in') }}
            </x-primary-button>
            <p class="text-center text-xs text-slate-500 mt-2">
                Don't have an account? 
                <a href="{{ route('register') }}" class="text-purple-400 font-semibold hover:underline">Sign up</a>
            </p>
        </div>
    </form>
</x-guest-layout>
