<aside class="sidebar" id="mainSidebar">

    {{-- HEADER --}}
    <div class="sidebar-header flex items-center justify-between px-4 mb-4 transition-all duration-300">

        <div class="py-2 ml-5 flex-shrink-0 brand-logo">
            <img src="/assets/ic_edu_logo.png"
                alt="Edu Logo"
                class="h-20 w-auto object-contain drop-shadow-sm" />
        </div>

        <button id="toggleSidebarBtn"
            class="text-white/60 hover:text-white p-1 rounded-md hover:bg-white/10 transition flex items-center justify-center">

            <x-lucide-panel-left-close class="w-5 h-5 icon-close" />
            <x-lucide-panel-left-open class="w-5 h-5 icon-open hidden" />

        </button>

    </div>

    {{-- NAVIGATION --}}
    <nav class="sidebar-nav">

        {{-- MAIN --}}
        <p class="nav-label font-heading">Main Menu</p>

        <a href="{{ route('examiner.dashboard') }}"
            class="s-btn {{ request()->routeIs('examiner.dashboard') ? 'active' : '' }}">

            <x-lucide-layout-dashboard class="w-5 h-5 min-w-[20px]" />

            <span class="s-label font-heading">
                Dashboard
            </span>

        </a>

        {{-- EXAM MANAGEMENT --}}
        <p class="nav-label font-heading">Exam Management</p>

        <a href="{{ route('examiner.exam-manage') }}"
            class="s-btn {{
        request()->routeIs('examiner.exam-manage') &&
        !request()->routeIs('examiner.exam-manage.type')
            ? 'active'
            : ''
    }}">

            <x-lucide-clipboard-check class="w-5 h-5 min-w-[20px]" />

            <span class="s-label font-heading">
                Exam Manage
            </span>

        </a>

        <a href="{{ route('examiner.exam-manage.type', 'ielts') }}"
            class="s-btn {{
        request()->route('type') === 'ielts'
            ? 'active'
            : ''
    }}">

            <x-lucide-clipboard-check class="w-5 h-5 min-w-[20px]" />

            <span class="s-label font-heading">
                IELTS Reviews
            </span>
        </a>

        <a href="{{ route('examiner.exam-manage.type', 'toefl') }}"
            class="s-btn {{
        request()->route('type') === 'toefl'
            ? 'active'
            : ''
    }}">
            <x-lucide-clipboard-check class="w-5 h-5 min-w-[20px]" />
            <span class="s-label font-heading">
                TOEFL Reviews
            </span>
        </a>

        <a href="{{ route('examiner.exam-manage.type', 'toeic') }}"
            class="s-btn {{
        request()->route('type') === 'toeic'
            ? 'active'
            : ''
    }}">
            <x-lucide-clipboard-check class="w-5 h-5 min-w-[20px]" />
            <span class="s-label font-heading">
                TOEIC Reviews
            </span>
        </a>

        {{-- ACCOUNT --}}
        <p class="nav-label font-heading">Account</p>

        <a href="{{ route('profile.edit') }}"
            class="s-btn {{ request()->routeIs('profile.edit') ? 'active' : '' }}">

            <x-lucide-settings class="w-5 h-5 min-w-[20px]" />

            <span class="s-label font-heading">
                Settings
            </span>

        </a>

    </nav>

    {{-- PROMO CARD --}}
    <div
        class="sidebar-promo mx-4 mb-3 mt-auto p-3 bg-white/10 rounded-2xl text-center border border-white/10 transition-opacity duration-300">

        <div class="w-20 h-20 mx-auto mb-3 rounded-full bg-white/10 flex items-center justify-center text-4xl">
            🧑‍🏫
        </div>

        <p class="text-sm font-heading font-bold text-white mb-1">
            Examiner Panel
        </p>

        <p class="text-[0.7rem] text-white/70 leading-tight">
            Review speaking and writing submissions professionally.
        </p>

    </div>

    {{-- LOGOUT --}}
    <div class="sidebar-bottom">

        <form method="POST"
            action="{{ route('logout') }}"
            class="w-full">

            @csrf

            <button type="submit"
                class="s-btn s-btn-logout w-full transition-colors duration-300">

                <x-lucide-log-out class="w-5 h-5 min-w-[20px]" />

                <span class="s-label font-heading">
                    Logout
                </span>

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