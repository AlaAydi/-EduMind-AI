<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-lg font-bold text-white leading-tight">Create your account</h2>
        <p class="text-xs text-slate-500 mt-1">Start your journey with EduMind AI e-learning today.</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full text-xs" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="e.g. Alex Rivers" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full text-xs" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="name@domain.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Role -->
        <div class="mt-4">
            <x-input-label for="role" :value="__('I want to be a')" />
            <select id="role" name="role" class="bg-slate-950/80 border-slate-800 text-slate-350 focus:border-purple-500 focus:ring-purple-500/30 rounded-xl shadow-sm transition-all duration-300 w-full text-xs font-semibold py-2.5 px-3 focus:outline-none" required>
                <option value="student" {{ old('role') == 'student' ? 'selected' : '' }}>Student (Enrolling, Quizzes, AI chat)</option>
                <option value="teacher" {{ old('role') == 'teacher' ? 'selected' : '' }}>Teacher (Create Courses, Manage Quizzes, Analytics)</option>
            </select>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full text-xs"
                            type="password"
                            name="password"
                            required autocomplete="new-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full text-xs"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-6">
            <a class="text-xs text-slate-400 hover:text-white transition-colors" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button>
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
