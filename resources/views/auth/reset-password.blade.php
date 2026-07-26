<x-guest-layout>
    @vite(['resources/css/login.css'])

    <div class="auth-container">
        <div class="auth-form-section">
            <div class="auth-content-wrapper">
                <img src="{{ asset(config('tenant.active.logo_auth')) }}" alt="IC EDU Logo" class="main-logo">

                <div class="welcome-text">
                    <h1>Reset Password</h1>
                    <p style="font-size: 13px; color: #64748b; margin-bottom: 25px;">
                        Enter your new password below to reset it.
                    </p>
                </div>

                <form method="POST" action="{{ route('password.store') }}" class="main-auth-form">
                    @csrf
                    <!-- Password Reset Token -->
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <div class="form-group">
                        <input id="email" type="email" name="email" placeholder="Email Address" class="form-input @error('email') input-error @enderror" value="{{ old('email', $request->email) }}" required autofocus>
                        @error('email') <span class="error-msg">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <input id="password" type="password" name="password" placeholder="New Password" class="form-input @error('password') input-error @enderror" required>
                        @error('password') <span class="error-msg">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <input id="password_confirmation" type="password" name="password_confirmation" placeholder="Confirm New Password" class="form-input @error('password_confirmation') input-error @enderror" required>
                        @error('password_confirmation') <span class="error-msg">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit" class="submit-btn">Reset Password</button>
                </form>
            </div>
        </div>

        <div class="auth-visual-section">
            <div class="speech-bubble">Almost there!</div>
            <img src="{{ asset('assets/maskot/login maskot.png') }}" alt="Mascot" class="mascot-img">
        </div>
    </div>
</x-guest-layout>
