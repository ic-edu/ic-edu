<x-guest-layout>
    <!-- Pastikan font Poppins termuat untuk komponen estetika ini -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;800&display=swap');
    </style>

    <div class="min-h-screen flex items-center justify-center bg-slate-50 relative overflow-hidden px-4">
        
        <!-- Decorative subtle blobs matching landing page aesthetic -->
        <div class="absolute top-0 right-0 w-64 md:w-96 h-64 md:h-96 bg-[#e0f2fe] rounded-bl-full -z-10 mix-blend-multiply opacity-60"></div>
        <div class="absolute bottom-0 left-0 w-48 md:w-80 h-48 md:h-80 bg-[#dbeafe] rounded-tr-full -z-10 mix-blend-multiply opacity-60"></div>

        <div class="max-w-[550px] w-full mx-auto bg-white border border-slate-100 p-8 sm:p-12 rounded-[32px] shadow-[0_20px_60px_rgba(37,99,235,0.08)] text-center relative z-10">
            
            <!-- Maskot Menggemaskan Cek Email -->
            <div class="flex justify-center mb-6">
                <img src="{{ asset('assets/maskot/verify_mascot.png') }}" alt="Check Email Mascot" class="h-48 object-contain mix-blend-multiply transform transition hover:scale-105 hover:-rotate-2 duration-300">
            </div>

            <h2 class="text-2xl sm:text-3xl font-extrabold text-[#1a3a5a] mb-4" style="font-family: 'Poppins', sans-serif;">
                Check Your Inbox
            </h2>
            
            <p class="text-slate-500 text-sm sm:text-base leading-relaxed mb-8 max-w-[420px] mx-auto">
                Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another.
            </p>

            @if (session('status') == 'verification-link-sent')
                <div class="mb-8 p-4 rounded-2xl bg-blue-50 border border-blue-100 text-sm font-bold text-blue-600 shadow-sm">
                    A new verification link has been sent to the email address you provided during registration.
                </div>
            @endif

            <div class="flex flex-col gap-3">
                <form method="POST" action="{{ route('verification.send') }}" class="w-full">
                    @csrf
                    <button type="submit" class="w-full px-8 py-3.5 rounded-full text-sm font-bold text-white bg-[#1a3a5a] hover:bg-[#14243b] transition-all text-center shadow-md transform hover:-translate-y-0.5">
                        Resend Verification Email
                    </button>
                </form>

                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <button type="submit" class="w-full px-8 py-3.5 rounded-full text-sm font-bold text-slate-500 bg-transparent hover:bg-slate-50 border border-transparent hover:border-slate-200 transition-all text-center">
                        Log Out
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
