<header class="topbar">
    <div class="flex items-center gap-4">
        <h1 class="text-[1.15rem] font-extrabold text-slate-800 leading-none tracking-tight">
            @yield('title', 'Dashboard')
        </h1>
    </div>

    <div class="topbar-right">
        <button class="notif-btn">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
            </svg>
            <div style="position:absolute; top:-2px; right:-2px; width:10px; height:10px; border-radius:50%; background:#ef4444; border:2px solid white;"></div>
        </button>

        <a href="{{ route('profile.edit') }}" style="text-decoration: none;">
            <div class="user-chip">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'U') }}&background=2563eb&color=fff&size=36" alt="avatar">
                <div class="hidden lg:block">
                    <p style="font-size:0.82rem;font-weight:700;color:var(--text);line-height:1.2;">{{ auth()->user()->name ?? 'Student' }}</p>
                    <p style="font-size:0.68rem;color:var(--muted);line-height:1.2;font-weight:600;">Test Taker</p>
                </div>
            </div>
        </a>
    </div>
</header>