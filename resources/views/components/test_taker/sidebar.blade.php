<aside class="sidebar">
    <div class="sidebar-logo">
        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.75 19 7.5 19s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
        </svg>
    </div>

    <nav class="sidebar-nav">
        {{-- MAIN MENU --}}
        <p class="nav-label">Main</p>
        <a href="{{ route('test_taker.dashboard') }}" class="s-btn {{ request()->routeIs('test_taker.dashboard') ? 'active' : '' }}">
            <span class="tip">Dashboard</span>
            <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="{{ request()->routeIs('test_taker.dashboard') ? '2.2' : '1.8' }}" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
        </a>

        {{-- LEARNING --}}
        <p class="nav-label">Learn</p>
        <a href="#" class="s-btn {{ request()->routeIs('#') ? 'active' : '' }}">
            <span class="tip">Browse Courses</span>
            <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="{{ request()->routeIs('#') ? '2.2' : '1.8' }}" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.75 19 7.5 19s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
            </svg>
        </a>
        <a href="#" class="s-btn">
            <span class="tip">My Courses</span>
            <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"/>
            </svg>
        </a>

        {{-- EXAMINATIONS --}}
        <p class="nav-label">Exams</p>
        <a href="{{ route('test_taker.exam.index') }}" class="s-btn {{ request()->routeIs('test_taker.exam.index') ? 'active' : '' }}">
            <span class="tip">Browse Exams</span>
            <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="{{ request()->routeIs('test_taker.exam.index') ? '2.2' : '1.8' }}" d="M13 10V3L4 14h7v7l9-11h-7z"/>
            </svg>
        </a>
        <a href="#" class="s-btn {{ request()->routeIs('test_taker.exam.attempt') ? 'active' : '' }}">
            <span class="tip">My Exams</span>
            <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="{{ request()->routeIs('test_taker.exam.attempt') ? '2.2' : '1.8' }}" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
        </a>

        {{-- ACCOUNT --}}
        <p class="nav-label">Account</p>
        <a href="{{ route('profile.edit') }}" class="s-btn {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
            <span class="tip">Settings / Profile</span>
            <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="{{ request()->routeIs('profile.edit') ? '2.2' : '1.8' }}" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
        </a>
    </nav>

    <div class="sidebar-bottom">
        <form method="POST" action="{{ route('logout') }}" style="width: 100%; display:flex; justify-content:center;">
            @csrf
            <button type="submit" class="s-btn" style="color: #ef4444;">
                <span class="tip">Logout</span>
                <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
            </button>
        </form>
        <div class="sidebar-avatar mt-1">
            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'U') }}&background=2563eb&color=fff&size=36"
                 alt="avatar" style="width:100%;height:100%;object-fit:cover;">
        </div>
    </div>
</aside>
