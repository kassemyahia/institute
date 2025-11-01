<x-auth-layout>
    <main class="auth-wrapper" role="main">
        @if (session('status'))
            <div class="session-status" role="status">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="auth-form" novalidate>
            @csrf

            <h1>{{ __('Log in') }}</h1>

            <div class="input-box">
                <label class="sr-only" for="email">{{ __('Email') }}</label>
                <input id="email" name="email" type="email" placeholder="{{ __('Email') }}" value="{{ old('email') }}" required autofocus autocomplete="username">
                <i class='bx bxs-user' aria-hidden="true"></i>
                @error('email')
                    <div class="validation-errors">{{ $message }}</div>
                @enderror
            </div>

            <div class="input-box">
                <label class="sr-only" for="password">{{ __('Password') }}</label>
                <input id="password" name="password" type="password" placeholder="{{ __('Password') }}" required autocomplete="current-password">
                <i class='bx bxs-lock-alt' aria-hidden="true"></i>
                @error('password')
                    <div class="validation-errors">{{ $message }}</div>
                @enderror
            </div>

            <div class="remember-forgot">
                <label for="remember">
                    <input id="remember" name="remember" type="checkbox" {{ old('remember') ? 'checked' : '' }}>
                    {{ __('Remember me') }}
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}">{{ __('Forgot your password?') }}</a>
                @endif
            </div>

            <button type="submit" class="btn">{{ __('Log in') }}</button>

            <div class="register-link">
                <p>{{ __('Don\'t have an account?') }} <a href="{{ route('register') }}">{{ __('Create one') }}</a></p>
            </div>
        </form>
    </main>
</x-auth-layout>
