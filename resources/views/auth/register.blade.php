<x-auth-layout>
    <main class="auth-wrapper" role="main">
        <form method="POST" action="{{ route('register') }}" class="auth-form" novalidate>
            @csrf

            <h1>{{ __('Create Account') }}</h1>

            <div class="input-box">
                <label class="sr-only" for="name">{{ __('Full name') }}</label>
                <input id="name" name="name" type="text" placeholder="{{ __('Full name') }}" value="{{ old('name') }}" required autofocus autocomplete="name">
                <i class='bx bxs-id-card' aria-hidden="true"></i>
                @error('name')
                    <div class="validation-errors">{{ $message }}</div>
                @enderror
            </div>

            <div class="input-box">
                <label class="sr-only" for="email">{{ __('Email') }}</label>
                <input id="email" name="email" type="email" placeholder="{{ __('Email') }}" value="{{ old('email') }}" required autocomplete="email">
                <i class='bx bxs-envelope' aria-hidden="true"></i>
                @error('email')
                    <div class="validation-errors">{{ $message }}</div>
                @enderror
            </div>

            <div class="input-box">
                <label class="sr-only" for="password">{{ __('Password') }}</label>
                <input id="password" name="password" type="password" placeholder="{{ __('Password') }}" required autocomplete="new-password">
                <i class='bx bxs-lock-alt' aria-hidden="true"></i>
                @error('password')
                    <div class="validation-errors">{{ $message }}</div>
                @enderror
            </div>

            <div class="input-box">
                <label class="sr-only" for="password_confirmation">{{ __('Confirm password') }}</label>
                <input id="password_confirmation" name="password_confirmation" type="password" placeholder="{{ __('Confirm password') }}" required autocomplete="new-password">
                <i class='bx bxs-lock' aria-hidden="true"></i>
                @error('password_confirmation')
                    <div class="validation-errors">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn">{{ __('Sign up') }}</button>

            <div class="register-link">
                <p>{{ __('Already have an account?') }} <a href="{{ route('login') }}">{{ __('Log in') }}</a></p>
            </div>
        </form>
    </main>
</x-auth-layout>
