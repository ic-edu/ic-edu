<aside class="sidebar" id="mainSidebar">
    <div class="sidebar-header flex items-center justify-between px-4 mb-4 transition-all duration-300">
        <div class="py-2 ml-5 flex-shrink-0 brand-logo">
            <img src="{{ asset(config('tenant.active.logo_sidebar')) }}" alt="Edu Logo" class="max-h-14 max-w-[180px] object-contain drop-shadow-sm" />
        </div>
        <button id="toggleSidebarBtn" class="text-white/60 hover:text-white p-1 rounded-md hover:bg-white/10 transition flex items-center justify-center">
            <x-lucide-panel-left-close class="w-5 h-5 icon-close" />
            <x-lucide-panel-left-open class="w-5 h-5 icon-open hidden" />
        </button>
    </div>

    <nav class="sidebar-nav">
        {{-- MAIN --}}
        <p class="nav-label font-heading">Main Menu</p>
        <a href="{{ route('test_taker.dashboard') }}" data-tour="dashboard" class="s-btn {{ request()->routeIs('test_taker.dashboard') ? 'active' : '' }}">
            <x-lucide-layout-dashboard class="w-5 h-5 min-w-[20px]" />
            <span class="s-label font-heading">Dashboard</span>
        </a>

        {{-- LEARN --}}
        <p class="nav-label font-heading">Learning</p>
        <a href="{{ route('test_taker.course.index') }}" data-tour="browse-courses" class="s-btn {{ request()->routeIs('test_taker.course.index') ? 'active' : '' }}">
            <x-lucide-book-open class="w-5 h-5 min-w-[20px]" />
            <span class="s-label font-heading">Browse Courses</span>
        </a>
        <a href="{{ route('test_taker.course.my_courses') }}" data-tour="my-courses" class="s-btn {{ request()->routeIs('test_taker.course.my_courses') ? 'active' : '' }}">
            <x-lucide-library class="w-5 h-5 min-w-[20px]" />
            <span class="s-label font-heading">My Courses</span>
        </a>

        {{-- EXAMS --}}
        <p class="nav-label font-heading">Exams</p>
        <a href="{{ route('test_taker.exam.index') }}" data-tour="browse-exams" class="s-btn {{ request()->routeIs('test_taker.exam.index') ? 'active' : '' }}">
            <x-lucide-file-text class="w-5 h-5 min-w-[20px]" />
            <span class="s-label font-heading">Browse Exams</span>
        </a>
        <a href="{{ route('test_taker.exam.my_exams') }}" data-tour="my-exams" class="s-btn {{ request()->routeIs('test_taker.exam.my_exams') ? 'active' : '' }}">
            <x-lucide-clipboard-check class="w-5 h-5 min-w-[20px]" />
            <span class="s-label font-heading">My Exams</span>
        </a>

        {{-- ACCOUNT --}}
        <p class="nav-label font-heading">Account</p>
        <a href="{{ route('test_taker.wallet') }}" data-tour="wallet" class="s-btn {{ request()->routeIs('test_taker.wallet') ? 'active' : '' }}">
            <x-lucide-wallet class="w-5 h-5 min-w-[20px]" />
            <span class="s-label font-heading">Wallet</span>
        </a>
        <a href="{{ route('profile.show') }}" data-tour="settings" class="s-btn {{ request()->routeIs('profile.show') ? 'active' : '' }}">
            <x-lucide-settings class="w-5 h-5 min-w-[20px]" />
            <span class="s-label font-heading">Settings</span>
        </a>
    </nav>

    <div class="sidebar-promo-card">

        {{-- Mascot image area --}}
        <div class="sidebar-promo-mascot">
            <img
                src="{{ asset('assets/target_score.png') }}"
                alt="Mascot"
                class="sidebar-promo-img"
                onerror="this.style.display='none'"
            >
            <div class="sidebar-promo-glow"></div>
        </div>

        {{-- Card content --}}
        <div class="sidebar-promo-body">
            <div class="sidebar-promo-shape-1"></div>
            <div class="sidebar-promo-shape-2"></div>

            <div class="sidebar-promo-content">
                <h4 class="sidebar-promo-title">Target Score!</h4>
                <p class="sidebar-promo-desc">Keep practicing to achieve your dream score.</p>
            </div>
        </div>

    </div>

    <div class="sidebar-bottom">
        <form method="POST" action="{{ route('logout') }}" class="w-full">
            @csrf
            <button type="submit" class="s-btn s-btn-logout w-full transition-colors duration-300">
                <x-lucide-log-out class="w-5 h-5 min-w-[20px]" />
                <span class="s-label font-heading">Logout</span>
            </button>
        </form>
    </div>
</aside>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const toggleBtn = document.getElementById('toggleSidebarBtn');
        const dashShell = document.querySelector('.dash-shell');

        if (toggleBtn && dashShell) {
            toggleBtn.addEventListener('click', () => {
                dashShell.classList.toggle('collapsed');
            });
        }
    });
</script>
@endpush
