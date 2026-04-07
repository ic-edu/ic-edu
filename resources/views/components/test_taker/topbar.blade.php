<header class="topbar">
    <div class="topbar-left">
        <h1 class="font-heading text-xl font-extrabold text-slate-800 flex items-center gap-2 leading-none">
            Welcome back, {{ explode(' ', auth()->user()->name ?? 'Student')[0] }} 
            <span class="wave-emoji text-2xl">👋</span>
        </h1>
        <!-- <p class="text-sm text-slate-500 font-medium mt-1">Let's learn something new today!</p> -->
    </div>

    <div class="topbar-right flex items-center gap-3 lg:gap-4">
        
        <button class="notif-btn">
            <x-lucide-mail class="w-5 h-5" />
        </button>

        <button class="notif-btn">
            <x-lucide-bell class="w-5 h-5" />
            <div class="notif-badge"></div>
        </button>

        {{-- <a href="{{ route('profile.edit') }}" class="user-chip-link">
            <div class="user-chip">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'Student') }}&background=6FAFB5&color=fff&size=36&bold=true" alt="Avatar">
                
                <div class="hidden lg:block text-left">
                    <p class="user-name font-heading">{{ auth()->user()->name ?? 'Student' }}</p>
                    <p class="user-role">Test Taker</p>
                </div>
            </div>
        </a> --}}
    </div>
</header>