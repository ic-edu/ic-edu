@extends('layouts.user')

@section('title', 'Access Denied')

@section('content')
<section class="w-full bg-slate-50 pt-32 pb-24 px-[5%] min-h-screen flex items-center justify-center">
    <div class="max-w-[700px] w-full mx-auto text-center relative z-10">
        
        <!-- Maskot Error dengan Efek Melayang -->
        <div class="flex justify-center -mb-8 relative z-20">
            <div class="absolute inset-0 bg-red-400 opacity-15 blur-[80px] rounded-full w-64 h-64 mx-auto -z-10"></div>
            
            <img src="{{ asset('assets/maskot/error_mascot.png') }}" alt="403 Mascot" class="h-64 sm:h-80 object-contain mix-blend-multiply animate-entrance filter grayscale-[20%]">
        </div>

        <h1 class="text-[100px] sm:text-[160px] leading-none font-black text-red-900 mb-0 relative z-10" style="font-family: 'Poppins', sans-serif; letter-spacing: -4px;">
            403
        </h1>
        <h2 class="text-2xl sm:text-3xl font-bold text-slate-800 mb-6" style="font-family: 'Poppins', sans-serif;">
            Oops! Access Denied
        </h2>
        
        <p class="text-slate-500 text-base sm:text-lg leading-relaxed mb-10 max-w-[500px] mx-auto">
            Sorry, you don't have permission to access this page. If you believe this is a system error, please contact our administrator.
        </p>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ url('/') }}" class="w-full sm:w-auto px-10 py-4 rounded-full text-sm font-bold text-white bg-red-800 hover:bg-red-900 transition-all text-center shadow-lg transform hover:-translate-y-1">
                Back to Home
            </a>
            
            <button onclick="window.history.back()" class="w-full sm:w-auto px-10 py-4 rounded-full text-sm font-bold text-red-900 bg-white border-2 border-red-200 hover:border-red-900 transition-all text-center">
                Previous Page
            </button>
        </div>
    </div>
</section>

<!-- Animasi Masuk (Hanya Sekali) -->
<style>
    .animate-entrance {
        animation: pop-in 0.7s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
        opacity: 0;
    }
    @keyframes pop-in {
        0% { transform: scale(0.7) translateY(30px); opacity: 0; }
        100% { transform: scale(1) translateY(0); opacity: 1; }
    }
</style>
@endsection
