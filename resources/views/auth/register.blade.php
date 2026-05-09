<x-guest-layout>
    @vite(['resources/css/login.css'])

    <div class="login-page-container" style="background-image: url('{{ asset('assets/login_bg.jpg') }}'); background-size: cover; background-position: center;">
        <div class="glass-card register-card">
            {{-- Logo Section --}}
            <div class="logo-container">
                <img src="{{ asset('assets/ic_edu_logo.png') }}" alt="IC EDU Logo" style="width: 220px; height: auto; max-width: 100%;">
            </div>

            <a href="{{ url('/') }}" class="back-link">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
                Back to homepage
            </a>
            
            <h1 class="header-title">Sign up</h1>
            <p class="subtitle">
                Already have an account? <a href="{{ route('login') }}">Log in</a>
            </p>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form-grid">
                    {{-- Name --}}
                    <div class="form-group">
                        <label for="name" class="form-label">Full name</label>
                        <input id="name" type="text" name="name" class="form-input @error('name') form-input-error @enderror" value="{{ old('name') }}" required autofocus>
                        @if ($errors->has('name'))
                            <span class="form-error">{{ $errors->first('name') }}</span>
                        @endif
                    </div>

                    {{-- Email --}}
                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input id="email" type="email" name="email" class="form-input @error('email') form-input-error @enderror" value="{{ old('email') }}" required >
                        @if ($errors->has('email'))
                            <span class="form-error">{{ $errors->first('email') }}</span>
                        @endif
                    </div>

                    {{-- Password --}}
                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <div class="password-wrapper">
                            <input id="password" type="password" name="password" class="form-input has-toggle @error('password') form-input-error @enderror" required >
                            <button type="button" class="password-toggle" onclick="togglePassword('password', this)" tabindex="-1">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                            </button>
                        </div>
                        @if ($errors->has('password'))
                            <span class="form-error">{{ $errors->first('password') }}</span>
                        @endif
                    </div>

                    {{-- Confirm Password --}}
                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <div class="password-wrapper">
                            <input id="password_confirmation" type="password" name="password_confirmation" class="form-input has-toggle @error('password_confirmation') form-input-error @enderror" required>
                            <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation', this)" tabindex="-1">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                            </button>
                        </div>
                        @if ($errors->has('password_confirmation'))
                            <span class="form-error">{{ $errors->first('password_confirmation') }}</span>
                        @endif
                    </div>
                </div>

                {{-- Terms and Conditions --}}
                <div class="terms-options" style="margin-bottom: 24px; margin-top: 8px;">
                    <label class="checkbox-container" for="terms_agreed">
                        <input type="checkbox" name="terms" id="terms_agreed" onclick="toggleSubmitBtn()">
                        <span style="font-size: 13.5px; line-height: 1.4;">I have read and agree to the <a href="#" style="color: #3b82f6; text-decoration: none; font-weight: 600;">Terms and Conditions</a></span>
                    </label>
                </div>

                <button type="submit" id="register-submit-btn" class="primary-btn disabled-btn" disabled>Sign up</button>
            </form>

            <div class="divider">or</div>

            <button type="button" class="google-btn">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                    <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                    <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                    <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                </svg>
                Continue with Google
            </button>

        </div>
    </div>

    <script>
        function togglePassword(inputId, button) {
            const input = document.getElementById(inputId);
            const iconShow = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle>';
            const iconHide = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line>';

            if (input.type === 'password') {
                input.type = 'text';
                button.innerHTML = '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">' + iconHide + '</svg>';
            } else {
                input.type = 'password';
                button.innerHTML = '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">' + iconShow + '</svg>';
            }
        }

        function toggleSubmitBtn() {
            const checkbox = document.getElementById('terms_agreed');
            const submitBtn = document.getElementById('register-submit-btn');
            
            if (checkbox.checked) {
                submitBtn.disabled = false;
                submitBtn.classList.remove('disabled-btn');
            } else {
                submitBtn.disabled = true;
                submitBtn.classList.add('disabled-btn');
            }
        }
    </script>
</x-guest-layout>