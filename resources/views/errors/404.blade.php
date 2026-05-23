@extends('layouts.user')

@section('title', 'Page Not Found')

@section('content')
<section class="w-full bg-slate-50 pt-32 pb-24 px-[5%] min-h-screen flex items-center justify-center">
    <div class="max-w-[700px] w-full mx-auto text-center relative z-10">
        
        <!-- Maskot Error dengan Efek Melayang -->
        <div class="flex justify-center -mb-8 relative z-20">
            <div class="absolute inset-0 bg-blue-300 opacity-20 blur-[80px] rounded-full w-64 h-64 mx-auto -z-10"></div>
            
            <img src="{{ asset('assets/maskot/error_mascot.png') }}" alt="404 Mascot" class="h-64 sm:h-80 object-contain mix-blend-multiply animate-entrance">
        </div>
        <h2 class="text-2xl sm:text-3xl font-bold text-slate-800 mb-6" style="font-family: 'Poppins', sans-serif;">
            Oops! Page Not Found
        </h2>
        
        <p class="text-slate-500 text-base sm:text-lg leading-relaxed mb-10 max-w-[500px] mx-auto">
            It looks like you're lost. The page you are looking for might have been moved, deleted, or simply doesn't exist.
        </p>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ url('/') }}" class="w-full sm:w-auto px-10 py-4 rounded-full text-sm font-bold text-white bg-[#1a3a5a] hover:bg-[#14243b] transition-all text-center shadow-lg transform hover:-translate-y-1">
                Back to Home
            </a>
            
            <button onclick="window.history.back()" class="w-full sm:w-auto px-10 py-4 rounded-full text-sm font-bold text-[#1a3a5a] bg-white border-2 border-slate-200 hover:border-[#1a3a5a] transition-all text-center">
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
