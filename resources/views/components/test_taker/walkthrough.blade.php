{{-- Onboarding Walkthrough — shown once per user via localStorage --}}
<div id="wt-root" x-data="walkthroughTour()" x-init="init()" x-cloak>

    {{-- ── Dark overlay (center steps only — spotlight box-shadow handles darkness for spotlighted steps) ── --}}
    <div x-show="active && !spotlightRect"
         x-transition:enter="wt__fade" x-transition:enter-start="wt__fade-from" x-transition:enter-end="wt__fade-to"
         x-transition:leave="wt__fade" x-transition:leave-start="wt__fade-to" x-transition:leave-end="wt__fade-from"
         class="wt__overlay">
    </div>

    {{-- ── Spotlight cutout ── --}}
    <div x-show="active && spotlightRect"
         class="wt__spotlight"
         :style="spotlightStyle">
        <div class="wt__spotlight-pulse"></div>
    </div>

    {{-- ── Tooltip card ── --}}
    <div x-show="active"
         class="wt__card"
         :style="cardStyle"
         x-transition:enter="wt__card-anim" x-transition:enter-start="wt__card-from" x-transition:enter-end="wt__card-to"
         x-transition:leave="wt__card-anim" x-transition:leave-start="wt__card-to" x-transition:leave-end="wt__card-from">

        {{-- Header row --}}
        <div class="wt__card-head">
            <span class="wt__counter" x-text="(currentIndex + 1) + ' of ' + steps.length"></span>
            <button @click="skip()" class="wt__skip-btn">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6L6 18M6 6l12 12"/></svg>
                Skip tour
            </button>
        </div>

        {{-- Step icon / mascot image --}}
        <div class="wt__icon-wrap" :class="step.img ? 'wt__icon-wrap--img' : ''">
            <template x-if="step.img">
                <img :src="step.img" class="wt__step-img" alt="" />
            </template>
            <template x-if="!step.img">
                <span class="wt__icon" x-text="step.icon"></span>
            </template>
        </div>

        {{-- Text --}}
        <h3 class="wt__title" x-text="step.title"></h3>
        <p class="wt__desc"  x-text="step.desc"></p>

        {{-- Progress dots --}}
        <div class="wt__dots">
            <template x-for="(s, i) in steps" :key="i">
                <button @click="goTo(i)" class="wt__dot" :class="i === currentIndex ? 'wt__dot--active' : ''"></button>
            </template>
        </div>

        {{-- Action buttons --}}
        <div class="wt__actions">
            <button x-show="currentIndex > 0" @click="prev()" class="wt__btn-prev">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5m7-7-7 7 7 7"/></svg>
                Back
            </button>
            <button @click="next()" class="wt__btn-next">
                <span x-text="isLast ? 'Get Started 🚀' : 'Next'"></span>
                <svg x-show="!isLast" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14m-7-7 7 7-7 7"/></svg>
            </button>
        </div>

    </div>

</div>

<style>
[x-cloak] { display: none !important; }

/* ── Overlay ── */
.wt__overlay {
    position: fixed;
    inset: 0;
    background: rgba(10, 18, 36, 0.78);
    z-index: 9900;
    pointer-events: none;
}

/* ── Spotlight ── */
.wt__spotlight {
    position: fixed;
    z-index: 9901;
    border-radius: 18px;
    box-shadow: 0 0 0 9999px rgba(10, 18, 36, 0.78);
    pointer-events: none;
    transition: top 0.35s cubic-bezier(0.4,0,0.2,1),
                left 0.35s cubic-bezier(0.4,0,0.2,1),
                width 0.35s cubic-bezier(0.4,0,0.2,1),
                height 0.35s cubic-bezier(0.4,0,0.2,1);
}
.wt__spotlight-pulse {
    position: absolute;
    inset: -4px;
    border-radius: 20px;
    border: 2px solid rgba(111, 175, 181, 0.8);
    animation: wt-pulse 2s ease-in-out infinite;
}
@keyframes wt-pulse {
    0%, 100% { opacity: 0.8; transform: scale(1); }
    50%       { opacity: 0.3; transform: scale(1.015); }
}

/* ── Nav item highlight during tour ── */
.wt-nav-highlight {
    background: rgba(255, 255, 255, 0.2) !important;
    border-radius: 12px !important;
    outline: 2px solid rgba(111, 175, 181, 1) !important;
    outline-offset: 2px;
    box-shadow: 0 0 0 5px rgba(111, 175, 181, 0.22), 0 0 24px rgba(111, 175, 181, 0.55) !important;
    position: relative;
    z-index: 9902;
}

/* ── Card ── */
.wt__card {
    position: fixed;
    z-index: 9910;
    width: 380px;
    background: white;
    border-radius: 24px;
    padding: 28px;
    box-shadow: 0 28px 72px rgba(0,0,0,0.26), 0 4px 18px rgba(0,0,0,0.1);
    transition: top 0.35s cubic-bezier(0.4,0,0.2,1),
                left 0.35s cubic-bezier(0.4,0,0.2,1);
}

/* ── Card transitions ── */
.wt__card-anim { transition: opacity 0.2s ease, transform 0.2s ease; }
.wt__card-from { opacity: 0; transform: scale(0.96) translateY(6px); }
.wt__card-to   { opacity: 1; transform: scale(1) translateY(0); }
.wt__fade { transition: opacity 0.25s ease; }
.wt__fade-from { opacity: 0; }
.wt__fade-to   { opacity: 1; }

/* ── Card head ── */
.wt__card-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
}
.wt__counter {
    font-size: 11px;
    font-weight: 800;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    color: #6FAFB5;
    background: rgba(111,175,181,0.1);
    padding: 4px 10px;
    border-radius: 99px;
    border: 1px solid rgba(111,175,181,0.25);
}
.wt__skip-btn {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 11px;
    font-weight: 600;
    color: #94a3b8;
    background: none;
    border: none;
    cursor: pointer;
    padding: 4px 6px;
    border-radius: 6px;
    font-family: inherit;
    transition: color 0.2s, background 0.2s;
}
.wt__skip-btn:hover { color: #64748b; background: #f1f5f9; }

/* ── Icon (emoji) ── */
.wt__icon-wrap {
    width: 56px;
    height: 56px;
    border-radius: 18px;
    background: linear-gradient(135deg, rgba(26,69,108,0.08) 0%, rgba(111,175,181,0.12) 100%);
    border: 1.5px solid rgba(26,69,108,0.1);
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 16px;
}
.wt__icon { font-size: 26px; line-height: 1; }

/* ── Mascot image variant ── */
.wt__icon-wrap--img {
    width: 130px;
    height: 110px;
    border-radius: 20px;
    background: linear-gradient(135deg, rgba(26,69,108,0.05) 0%, rgba(111,175,181,0.08) 100%);
    border: 1.5px solid rgba(111,175,181,0.18);
    overflow: hidden;
    margin-left: auto;
    margin-right: auto;
}
.wt__step-img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    padding: 6px;
}

/* ── Text ── */
.wt__title {
    font-size: 19px;
    font-weight: 800;
    color: #0D1B2A;
    margin: 0 0 10px;
    font-family: 'Poppins', sans-serif;
    line-height: 1.3;
}
.wt__desc {
    font-size: 13.5px;
    color: #64748b;
    line-height: 1.75;
    margin: 0 0 22px;
}

/* ── Progress dots ── */
.wt__dots {
    display: flex;
    align-items: center;
    gap: 6px;
    margin-bottom: 22px;
}
.wt__dot {
    width: 7px;
    height: 7px;
    border-radius: 99px;
    background: #e2e8f0;
    border: none;
    cursor: pointer;
    padding: 0;
    transition: width 0.25s ease, background 0.25s ease;
}
.wt__dot--active {
    width: 24px;
    background: #1A456C;
}
.wt__dot:hover:not(.wt__dot--active) { background: #94a3b8; }

/* ── Actions ── */
.wt__actions {
    display: flex;
    align-items: center;
    gap: 10px;
}
.wt__btn-prev {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 11px 18px;
    border-radius: 12px;
    border: 1.5px solid #e2e8f0;
    background: white;
    font-size: 13px;
    font-weight: 700;
    color: #64748b;
    cursor: pointer;
    font-family: inherit;
    transition: border-color 0.2s, color 0.2s;
}
.wt__btn-prev:hover { border-color: #94a3b8; color: #1A456C; }
.wt__btn-next {
    flex: 1;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 12px 22px;
    border-radius: 12px;
    border: none;
    background: linear-gradient(135deg, #1A456C 0%, #2a6b8a 100%);
    font-size: 13.5px;
    font-weight: 700;
    color: white;
    cursor: pointer;
    font-family: inherit;
    transition: filter 0.2s, transform 0.2s;
}
.wt__btn-next:hover { filter: brightness(1.1); transform: translateY(-1px); }
</style>

@push('scripts')
<script>
function walkthroughTour() {
    return {
        active: false,
        currentIndex: 0,
        spotlightRect: null,

        steps: [
            {
                target:   null,
                spotlight: null,
                img:  '/assets/target_score.png',
                title: 'Welcome to iC.Edu!',
                desc: 'Your all-in-one platform for TOEIC, IELTS, and TOEFL preparation. Let us take you on a quick tour so you can hit the ground running.',
                position: 'center',
            },
            {
                target:   '[data-tour="dashboard"]',
                spotlight: '.sidebar',
                icon: '🏠',
                title: 'Dashboard',
                desc: "Your home base. Get a snapshot of your learning progress, recent activity, and quick links to pick up right where you left off.",
                position: 'right',
            },
            {
                target:   '[data-tour="browse-courses"]',
                spotlight: '.sidebar',
                icon: '📚',
                title: 'Browse Courses',
                desc: 'Explore structured learning paths with video, reading, and quiz lessons — carefully built to strengthen your skills step by step.',
                position: 'right',
            },
            {
                target:   '[data-tour="my-courses"]',
                spotlight: '.sidebar',
                icon: '🗂️',
                title: 'My Courses',
                desc: 'All your enrolled courses in one place. Track your progress and continue learning right where you stopped.',
                position: 'right',
            },
            {
                target:   '[data-tour="browse-exams"]',
                spotlight: '.sidebar',
                icon: '📝',
                title: 'Browse Exams',
                desc: 'Find and enroll in TOEIC, IELTS, and TOEFL simulation exams. Each exam mirrors the real CBT format so you are fully prepared on test day.',
                position: 'right',
            },
            {
                target:   '[data-tour="my-exams"]',
                spotlight: '.sidebar',
                icon: '📋',
                title: 'My Exams',
                desc: 'Track your enrolled exams, resume ongoing sessions, and review your graded results and detailed score reports anytime.',
                position: 'right',
            },
            {
                target:   '[data-tour="settings"]',
                spotlight: '.sidebar',
                icon: '⚙️',
                title: 'Account Settings',
                desc: 'Update your profile photo, set your target score, choose your exam focus, and manage your account preferences.',
                position: 'right',
            },
            {
                target:   null,
                spotlight: null,
                img:  '/assets/maskot/pen maskot.png',
                title: "You're All Set!",
                desc: "You now know your way around iC.Edu. Start by browsing courses or exams — your learning journey begins right now!",
                position: 'center',
            },
        ],

        get step()    { return this.steps[this.currentIndex]; },
        get isFirst() { return this.currentIndex === 0; },
        get isLast()  { return this.currentIndex === this.steps.length - 1; },

        storageKey: 'ic_edu_tour_v1_{{ auth()->id() }}',

        init() {
            if (!localStorage.getItem(this.storageKey)) {
                setTimeout(() => {
                    this.active = true;
                    this.updateSpotlight();
                }, 600);
            }
        },

        clearNavHighlight() {
            document.querySelectorAll('.wt-nav-highlight').forEach(el => el.classList.remove('wt-nav-highlight'));
        },

        updateSpotlight() {
            this.clearNavHighlight();

            const spotlightSel = this.step?.spotlight || this.step?.target;
            const navSel       = this.step?.target;

            if (!spotlightSel) {
                this.spotlightRect = null;
                return;
            }

            const el = document.querySelector(spotlightSel);
            if (!el) {
                this.spotlightRect = null;
                return;
            }

            const rect = el.getBoundingClientRect();
            const pad  = spotlightSel === '.sidebar' ? 6 : 8;
            this.spotlightRect = {
                top:    rect.top    - pad,
                left:   rect.left   - pad,
                width:  rect.width  + pad * 2,
                height: rect.height + pad * 2,
            };

            // Highlight the specific nav item within the sidebar spotlight
            if (navSel && navSel !== spotlightSel) {
                const navEl = document.querySelector(navSel);
                if (navEl) navEl.classList.add('wt-nav-highlight');
            }
        },

        next() {
            if (this.isLast) { this.finish(); return; }
            this.currentIndex++;
            this.$nextTick(() => this.updateSpotlight());
        },

        prev() {
            if (this.currentIndex > 0) {
                this.currentIndex--;
                this.$nextTick(() => this.updateSpotlight());
            }
        },

        goTo(i) {
            this.currentIndex = i;
            this.$nextTick(() => this.updateSpotlight());
        },

        skip()   { this.clearNavHighlight(); this.finish(); },
        finish() {
            this.clearNavHighlight();
            localStorage.setItem(this.storageKey, '1');
            this.active = false;
        },

        get spotlightStyle() {
            if (!this.spotlightRect) return 'display:none;';
            const r = this.spotlightRect;
            return `top:${r.top}px; left:${r.left}px; width:${r.width}px; height:${r.height}px;`;
        },

        get cardStyle() {
            const cardW = 380;
            const cardH = 420; // estimated
            const vw = window.innerWidth;
            const vh = window.innerHeight;
            const margin = 20;

            // Centered steps (welcome / done)
            if (!this.spotlightRect || this.step?.position === 'center') {
                return `left:${(vw - cardW) / 2}px; top:${(vh - cardH) / 2}px;`;
            }

            const r   = this.spotlightRect;
            const gap = 20;

            // Place to the right of the spotlight
            let left = r.left + r.width + gap;
            let top  = r.top + r.height / 2 - cardH / 2;

            // If card overflows right edge, place to the left
            if (left + cardW > vw - margin) {
                left = r.left - cardW - gap;
            }
            // If card overflows left edge, center horizontally
            if (left < margin) {
                left = (vw - cardW) / 2;
            }

            // Clamp top
            top = Math.max(margin, Math.min(top, vh - cardH - margin));

            return `left:${left}px; top:${top}px;`;
        },
    };
}
</script>
@endpush
