<x-guest-layout>
    @vite(['resources/css/login.css'])

    <div class="auth-container">
        <div class="auth-form-section">
            <div class="auth-content-wrapper">
                <img src="{{ asset(config('tenant.active.logo_auth')) }}" alt="IC EDU Logo" class="main-logo">

                <div class="welcome-text">
                    <h1>Forgot Password?</h1>
                    <p style="font-size: 13px; color: #64748b; margin-bottom: 25px;">
                        No problem. Just let us know your email address and we will email you a password reset link.
                    </p>
                </div>

                <!-- Session Status -->
                @if (session('status'))
                    <div style="width: 100%; padding: 10px; background-color: #dcfce7; color: #166534; border-radius: 8px; font-size: 13px; margin-bottom: 15px;">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}" class="main-auth-form">
                    @csrf
                    <div class="form-group">
                        <input id="email" type="email" name="email" placeholder="Email Address" class="form-input @error('email') input-error @enderror" value="{{ old('email') }}" required autofocus>
                        @error('email') <span class="error-msg">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit" class="submit-btn">Send Reset Link</button>
                </form>

                <p class="footer-auth-text">
                    Remember your password? <a href="{{ route('login') }}" class="auth-link">Sign In</a>
                </p>
            </div>
        </div>

        <div class="auth-visual-section">
            <div class="speech-bubble">We'll help!</div>
            <img src="{{ asset('assets/maskot/login maskot.png') }}" alt="Mascot" class="mascot-img">
        </div>
    </div>
</x-guest-layout>
