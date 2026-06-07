<aside class="sidebar" id="mainSidebar">
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

    <nav class="sidebar-nav">

        <p class="nav-label font-heading">Main Menu</p>

        <a href="{{ route('examiner.dashboard') }}"
            class="s-btn {{ request()->routeIs('examiner.dashboard') ? 'active' : '' }}">

            <x-lucide-layout-dashboard class="w-5 h-5 min-w-[20px]" />

            <span class="s-label font-heading">
                Dashboard
            </span>

        </a>

        <p class="nav-label font-heading">Assesment Center</p>

        <a href="{{ route('examiner.exam-reviews') }}"
            class="s-btn {{
        request()->routeIs('examiner.exam-reviews') &&
        !request()->routeIs('examiner.exam-reviews.type')
            ? 'active'
            : ''
    }}">

            <x-lucide-clipboard-check class="w-5 h-5 min-w-[20px]" />

            <span class="s-label font-heading">
                Exams Reviews
            </span>

        </a>

        <a href="{{ route('examiner.course-reviews') }}"
            class="s-btn {{
        request()->routeIs('examiner.course-reviews')
            ? 'active'
            : ''
    }}">

            <x-lucide-clipboard-check class="w-5 h-5 min-w-[20px]" />

            <span class="s-label font-heading">
                Courses Reviews
            </span>
        </a>


        <p class="nav-label font-heading">Account</p>

        <a href="{{ route('examiner.settings') }}"
            class="s-btn {{ request()->routeIs('examiner.settings') ? 'active' : '' }}">

            <x-lucide-settings class="w-5 h-5 min-w-[20px]" />

            <span class="s-label font-heading">
                Settings
            </span>

        </a>

    </nav>
    {{-- PROMO CARD --}}
    <div class="examiner-sidebar-promo-wrap mx-4 mb-3 mt-auto">
        <div class="examiner-sidebar-mascot">
            <img src="{{ asset('assets/maskot/pen maskot.png') }}"
                alt="Examiner Mascot">
        </div>

        <div class="examiner-sidebar-promo">
            <div class="promo-bg-dots"></div>
            <div class="promo-circle promo-circle-lg"></div>
            <div class="promo-circle promo-circle-sm"></div>

            <div class="promo-content">
                <p class="promo-title">
                    Examiner Panel
                </p>

                <p class="promo-text">
                    Review speaking and writing submissions professionally.
                </p>
            </div>
        </div>
    </div>

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

<style>
    .examiner-sidebar-promo-wrap {
        position: relative;
        margin-top: auto;
        padding-top: 52px;
    }

    .examiner-sidebar-mascot {
        position: absolute;
        top: 0;
        left: 50%;
        transform: translateX(-50%);
        z-index: 3;
        width: 120px;
        display: flex;
        justify-content: center;
        pointer-events: none;
    }

    .examiner-sidebar-mascot img {
        width: 150px;
        height: auto;
        object-fit: contain;
        filter: drop-shadow(0 10px 18px rgba(0, 0, 0, 0.22));
    }

    .examiner-sidebar-promo {
        position: relative;
        overflow: hidden;
        border-radius: 22px;
        padding: 58px 18px 18px;
        text-align: center;
        border: 1px solid rgba(255, 255, 255, 0.08);
        background: linear-gradient(135deg, #1f628a 0%, #15607b 100%);
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.08);
    }

    .examiner-sidebar-promo .promo-bg-dots {
        position: absolute;
        inset: 0;
        opacity: 0.20;
        background-image: radial-gradient(rgba(255, 255, 255, 0.45) 1px, transparent 1px);
        background-size: 14px 14px;
        pointer-events: none;
    }

    .examiner-sidebar-promo .promo-circle {
        position: absolute;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.08);
        pointer-events: none;
    }

    .examiner-sidebar-promo .promo-circle-lg {
        width: 120px;
        height: 120px;
        right: -18px;
        top: 18px;
    }

    .examiner-sidebar-promo .promo-circle-sm {
        width: 70px;
        height: 70px;
        left: -16px;
        bottom: -12px;
    }

    .examiner-sidebar-promo .promo-content {
        position: relative;
        z-index: 2;
    }

    .examiner-sidebar-promo .promo-title {
        font-size: 1.65rem;
        font-weight: 900;
        line-height: 1.1;
        color: white;
        margin-bottom: 8px;
        font-family: 'DM Sans', sans-serif;
    }

    .examiner-sidebar-promo .promo-text {
        font-size: 0.92rem;
        line-height: 1.6;
        color: rgba(255, 255, 255, 0.88);
        margin: 0;
        font-weight: 500;
    }

    /* kalau sidebar collapse */
    .collapsed .examiner-sidebar-promo-wrap {
        padding-top: 0;
    }

    .collapsed .examiner-sidebar-mascot,
    .collapsed .examiner-sidebar-promo .promo-content,
    .collapsed .examiner-sidebar-promo .promo-bg-dots,
    .collapsed .examiner-sidebar-promo .promo-circle {
        display: none;
    }

    .collapsed .examiner-sidebar-promo {
        min-height: 64px;
        padding: 0;
        background: rgba(255, 255, 255, 0.08);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* mobile bottom sidebar tidak kena */
    @media (max-width: 1023px) {
        .examiner-sidebar-promo-wrap {
            padding-top: 60px;
        }

        .examiner-sidebar-mascot {
            width: 96px;
        }

        .examiner-sidebar-mascot img {
            width: 96px;
        }

        .examiner-sidebar-promo {
            padding: 60px 16px 18px;
        }

        .examiner-sidebar-promo .promo-title {
            font-size: 1.5rem;
        }

        .examiner-sidebar-promo .promo-text {
            font-size: 0.88rem;
        }

        .examiner-sidebar-promo-wrap,
        .examiner-sidebar-promo,
        .sidebar-promo,
        .examiner-sidebar-mascot {
            display: none !important;
        }
    }
</style>