<header class="topbar">
    <div class="flex items-center gap-6">
        <div>
            <p class="text-[0.65rem] text-slate-400 font-bold tracking-wider leading-none mb-1.5 uppercase">IC-EDU Portal</p>
            <h1 class="text-[1.15rem] font-extrabold text-slate-800 leading-none tracking-tight">
                @yield('title', 'Dashboard')
            </h1>
        </div>
        <div style="width:1px;height:32px;background:var(--border);"></div>
        <div class="topbar-search">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="text" placeholder="Search courses or exams...">
        </div>
    </div>

    <div class="topbar-right">
        <div style="display:flex;align-items:center;gap:7px;background:#fff7ed;border:1.5px solid #fed7aa;border-radius:12px;padding:6px 14px;">
            <span class="fire-emoji" style="font-size:1.1rem;">🔥</span>
            <span style="font-size:0.8rem;font-weight:800;color:#ea580c;">Active Streak</span>
        </div>

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
