<x-guest-layout>
    @vite(['resources/css/login.css'])

    <div class="auth-container">
        <div class="auth-form-section">
            <div class="auth-content-wrapper">
                <img src="{{ asset('assets/icidu_logo.png') }}" alt="IC EDU Logo" class="main-logo">

                <div class="welcome-text">
                    <h1>Hi! Get started with your account today.</h1>
                </div>

                <form method="POST" action="{{ route('login') }}" class="main-auth-form">
                    @csrf
                    <div class="form-group">
                        <input id="email" type="email" name="email" placeholder="Email" class="form-input @error('email') input-error @enderror" value="{{ old('email') }}" required autofocus>
                        @error('email') <span class="error-msg">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group" style="position: relative;">
                        <input id="password" type="password" name="password" placeholder="Password" class="form-input @error('password') input-error @enderror" required>
                        @error('password') <span class="error-msg">{{ $message }}</span> @enderror
                        <div style="text-align: right; margin-top: 5px;">
                            <a href="{{ route('password.request') }}" style="font-size: 11px; color: #007bff; text-decoration: none; font-weight: 500;">Forgot password?</a>
                        </div>
                    </div>

                    <button type="submit" class="submit-btn">Submit</button>
                </form>

                <div class="divider"><span>or</span></div>

                <a href="{{ route('login.google') }}" class="google-login-btn" style="text-decoration: none; display: flex; justify-content: center; align-items: center; gap: 8px;">
                    <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" alt="Google" width="16">
                    Continue With Google
                </a>

                <p class="footer-auth-text">
                    Don't have an account? <a href="{{ route('register') }}" class="auth-link">Sign Up</a>
                </p>
            </div>
        </div>

        <div class="auth-visual-section">
            <div class="speech-bubble">Welcome!</div>
            <img src="{{ asset('assets/maskot/login maskot.png') }}" alt="Mascot" class="mascot-img">
        </div>
    </div>
</x-guest-layout>