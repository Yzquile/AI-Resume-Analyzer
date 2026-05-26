<x-guest-layout>
    <x-slot name="title">Sign Up — ResumeAI</x-slot>

    <div class="text-center mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Create your account</h1>
        <p class="text-gray-500 mt-2">Start analyzing resumes with AI for free</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Full Name')" class="text-sm font-semibold text-gray-700" />
            <x-text-input 
                id="name" 
                class="block mt-2 w-full px-4 py-3 rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-200" 
                type="text" 
                name="name" 
                :value="old('name')" 
                required 
                autofocus 
                autocomplete="name"
                placeholder="John Doe"
            />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" class="text-sm font-semibold text-gray-700" />
            <x-text-input 
                id="email" 
                class="block mt-2 w-full px-4 py-3 rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-200" 
                type="email" 
                name="email" 
                :value="old('email')" 
                required 
                autocomplete="username"
                placeholder="you@example.com"
            />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" class="text-sm font-semibold text-gray-700" />
            <x-text-input 
                id="password" 
                class="block mt-2 w-full px-4 py-3 rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-200"
                type="password"
                name="password"
                required 
                autocomplete="new-password"
                placeholder="••••••••"
            />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-sm font-semibold text-gray-700" />
            <x-text-input 
                id="password_confirmation" 
                class="block mt-2 w-full px-4 py-3 rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-200"
                type="password"
                name="password_confirmation" 
                required 
                autocomplete="new-password"
                placeholder="••••••••"
            />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-xl transition shadow-lg shadow-indigo-600/20 mt-6">
            {{ __('Create Account') }}
        </button>

        <p class="text-center text-sm text-gray-500 mt-6">
            Already have an account? 
            <a href="{{ route('login') }}" class="font-semibold text-indigo-600 hover:text-indigo-500 transition">Log in</a>
        </p>
    </form>
</x-guest-layout>