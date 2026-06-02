<x-guest-layout>
    @vite(['resources/css/login.css'])

    <div class="auth-container">
        <div class="auth-form-section">
            <div class="auth-content-wrapper">
                <img src="{{ asset('assets/icidu_logo.png') }}" alt="IC EDU Logo" class="main-logo">

                <div class="welcome-text">
                    <h1>Hi! Get started with your account today.</h1>
                </div>

                <form method="POST" action="{{ route('register') }}" class="main-auth-form">
                    @csrf
                    <div class="form-group">
                        <input id="name" type="text" name="name" placeholder="Fullname" class="form-input @error('name') input-error @enderror" value="{{ old('name') }}" required autofocus>
                    </div>

                    <div class="form-group">
                        <input id="email" type="email" name="email" placeholder="Email" class="form-input @error('email') input-error @enderror" value="{{ old('email') }}" required>
                    </div>

                    <div class="form-group">
                        <input id="password" type="password" name="password" placeholder="Password" class="form-input @error('password') input-error @enderror" required>
                    </div>

                    <div class="form-group">
                        <input id="password_confirmation" type="password" name="password_confirmation" placeholder="Confirm Password" class="form-input" required>
                    </div>

                    <div class="terms-container" style="margin-bottom: 10px;">
                        <label class="checkbox-label" style="font-size: 11px; display: flex; align-items: center; gap: 6px; color: #64748b; cursor: pointer;">
                            <input type="checkbox" name="terms" id="terms_agreed" onclick="toggleSubmitBtn()"> 
                            <span>I agree to the Terms and Conditions</span>
                        </label>
                    </div>

                    <button type="submit" id="register-submit-btn" class="submit-btn disabled-btn" disabled>Submit</button>
                </form>

                <div class="divider"><span>or</span></div>

                <a href="{{ route('login.google') }}" class="google-login-btn" style="text-decoration: none; display: flex; justify-content: center; align-items: center; gap: 8px;">
                    <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" alt="Google" width="16">
                    Continue With Google
                </a>

                <p class="footer-auth-text">
                    Already have an account? <a href="{{ route('login') }}" class="auth-link">Sign In</a>
                </p>
            </div>
        </div>

        <div class="auth-visual-section">
            <div class="speech-bubble">Welcome!</div>
            <img src="{{ asset('assets/maskot/login maskot.png') }}" alt="Mascot" class="mascot-img">
        </div>
    </div>
    
    <script>
        function toggleSubmitBtn() {
            const checkbox = document.getElementById('terms_agreed');
            const submitBtn = document.getElementById('register-submit-btn');
            submitBtn.disabled = !checkbox.checked;
            submitBtn.style.opacity = checkbox.checked ? "1" : "0.6";
        }
    </script>
</x-guest-layout>