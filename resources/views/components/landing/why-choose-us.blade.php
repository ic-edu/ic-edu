@push('styles')
<style>
    /* =========================================================
       DECORATIVE FLOATING MASCOTS & CLOUDS
       ========================================================= */
    .floating-cloud {
        animation: cloudFloat 6s ease-in-out infinite;
        z-index: 1;
    }

    @keyframes cloudFloat {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-15px); }
    }

    /* Small sizes and light background opacity on mobile so they don't block readability */
    .floating-cloud img {
        width: 50px;
        opacity: 0.15;
        transition: width 0.3s ease, opacity 0.3s ease;
    }

    /* Target specific owl mascots */
    .floating-cloud-mascot img {
        width: 54px;
        opacity: 0.25;
    }

    /* On desktop, scale them up and show them clearly */
    @media (min-width: 1025px) {
        .floating-cloud img {
            width: 120px;
            opacity: 0.35;
        }
        .floating-cloud-mascot img {
            width: 130px;
            opacity: 0.95;
        }
    }

    /* =========================================================
       LIGHT BENTO GRID CONTAINER & CARDS
       ========================================================= */
    .puzzle-board {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 28px;
        width: 100%;
        margin-top: 16px;
        position: relative;
        z-index: 10;
    }

    .feature-card {
        background-color: #ffffff;
        border: 1px solid rgba(226, 232, 240, 0.9);
        border-radius: 24px;
        padding: 40px 32px;
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        cursor: pointer;
        transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275), border-color 0.3s ease, box-shadow 0.3s ease;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.01), 0 2px 4px -1px rgba(0, 0, 0, 0.005), 0 10px 20px -3px rgba(0, 0, 0, 0.02);
    }

    [data-theme="dark"] .feature-card {
        background-color: #1e293b;
        border-color: rgba(51, 65, 85, 0.6);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    .feature-card:hover {
        transform: translateY(-8px);
    }

    /* Hover accents and soft glow shadows */
    .f-toeic:hover {
        border-color: #3b82f6;
        box-shadow: 0 20px 25px -5px rgba(59, 130, 246, 0.08), 0 10px 10px -5px rgba(59, 130, 246, 0.04);
    }
    .f-toefl:hover {
        border-color: #6366f1;
        box-shadow: 0 20px 25px -5px rgba(99, 102, 241, 0.08), 0 10px 10px -5px rgba(99, 102, 241, 0.04);
    }
    .f-ielts:hover {
        border-color: #14b8a6;
        box-shadow: 0 20px 25px -5px rgba(20, 184, 166, 0.08), 0 10px 10px -5px rgba(20, 184, 166, 0.04);
    }
    .f-progress:hover {
        border-color: #8b5cf6;
        box-shadow: 0 20px 25px -5px rgba(139, 92, 246, 0.08), 0 10px 10px -5px rgba(139, 92, 246, 0.04);
    }
    .f-lms:hover {
        border-color: #06b6d4;
        box-shadow: 0 20px 25px -5px rgba(6, 182, 212, 0.08), 0 10px 10px -5px rgba(6, 182, 212, 0.04);
    }
    .f-certificate:hover {
        border-color: #10b981;
        box-shadow: 0 20px 25px -5px rgba(16, 185, 129, 0.08), 0 10px 10px -5px rgba(16, 185, 129, 0.04);
    }

    /* Dark Mode hover glows */
    [data-theme="dark"] .f-toeic:hover {
        border-color: #3b82f6;
        box-shadow: 0 20px 25px -5px rgba(59, 130, 246, 0.2), 0 10px 10px -5px rgba(59, 130, 246, 0.1);
    }
    [data-theme="dark"] .f-toefl:hover {
        border-color: #6366f1;
        box-shadow: 0 20px 25px -5px rgba(99, 102, 241, 0.2), 0 10px 10px -5px rgba(99, 102, 241, 0.1);
    }
    [data-theme="dark"] .f-ielts:hover {
        border-color: #14b8a6;
        box-shadow: 0 20px 25px -5px rgba(20, 184, 166, 0.2), 0 10px 10px -5px rgba(20, 184, 166, 0.1);
    }
    [data-theme="dark"] .f-progress:hover {
        border-color: #8b5cf6;
        box-shadow: 0 20px 25px -5px rgba(139, 92, 246, 0.2), 0 10px 10px -5px rgba(139, 92, 246, 0.1);
    }
    [data-theme="dark"] .f-lms:hover {
        border-color: #06b6d4;
        box-shadow: 0 20px 25px -5px rgba(6, 182, 212, 0.2), 0 10px 10px -5px rgba(6, 182, 212, 0.1);
    }
    [data-theme="dark"] .f-certificate:hover {
        border-color: #10b981;
        box-shadow: 0 20px 25px -5px rgba(16, 185, 129, 0.2), 0 10px 10px -5px rgba(16, 185, 129, 0.1);
    }

    /* ===== ICON STYLING ===== */
    .feature-icon-wrapper {
        width: 56px;
        height: 56px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 24px;
        transition: transform 0.3s ease;
    }

    .feature-card:hover .feature-icon-wrapper {
        transform: scale(1.1) rotate(3deg);
    }

    /* Colored icon badges */
    .f-toeic .feature-icon-wrapper { background-color: rgba(59, 130, 246, 0.1); color: #3b82f6; }
    .f-toefl .feature-icon-wrapper { background-color: rgba(99, 102, 241, 0.1); color: #6366f1; }
    .f-ielts .feature-icon-wrapper { background-color: rgba(20, 184, 166, 0.1); color: #0d9488; }
    .f-progress .feature-icon-wrapper { background-color: rgba(139, 92, 246, 0.1); color: #8b5cf6; }
    .f-lms .feature-icon-wrapper { background-color: rgba(6, 182, 212, 0.1); color: #0891b2; }
    .f-certificate .feature-icon-wrapper { background-color: rgba(16, 185, 129, 0.1); color: #059669; }

    /* Dark Mode icon background adjustments */
    [data-theme="dark"] .f-toeic .feature-icon-wrapper { background-color: rgba(59, 130, 246, 0.2); color: #60a5fa; }
    [data-theme="dark"] .f-toefl .feature-icon-wrapper { background-color: rgba(99, 102, 241, 0.2); color: #818cf8; }
    [data-theme="dark"] .f-ielts .feature-icon-wrapper { background-color: rgba(20, 184, 166, 0.2); color: #2dd4bf; }
    [data-theme="dark"] .f-progress .feature-icon-wrapper { background-color: rgba(139, 92, 246, 0.2); color: #a78bfa; }
    [data-theme="dark"] .f-lms .feature-icon-wrapper { background-color: rgba(6, 182, 212, 0.2); color: #22d3ee; }
    [data-theme="dark"] .f-certificate .feature-icon-wrapper { background-color: rgba(16, 185, 129, 0.2); color: #34d399; }

    /* ===== CARD TEXT STYLES ===== */
    .feature-card h3 {
        font-family: 'Poppins', sans-serif;
        font-size: 1.35rem;
        font-weight: 800;
        line-height: 1.3;
        margin-bottom: 12px;
        color: #1a3a5a;
        transition: color 0.3s ease;
    }

    [data-theme="dark"] .feature-card h3 {
        color: #f1f5f9;
    }

    .feature-card:hover h3 {
        color: #1e3b68;
    }

    [data-theme="dark"] .feature-card:hover h3 {
        color: #ffffff;
    }

    .feature-card p {
        font-size: 0.92rem;
        line-height: 1.65;
        font-weight: 500;
        color: #5d6d7e;
        transition: color 0.3s ease;
    }

    [data-theme="dark"] .feature-card p {
        color: #94a3b8;
    }

    /* =========================================================
       RESPONSIVE CARD GRID (< 1025px)
       ========================================================= */
    @media (max-width: 1024px) {
        .puzzle-board {
            grid-template-columns: 1fr;
            gap: 20px;
            padding: 0 16px;
        }

        .feature-card {
            border-radius: 20px;
            padding: 35px 28px;
            min-height: 180px;
        }
    }

    @media (min-width: 640px) and (max-width: 1024px) {
        .puzzle-board {
            grid-template-columns: repeat(2, 1fr);
            max-width: 800px;
            margin: 0 auto;
        }
    }
</style>
@endpush

{{-- SECTION 6 — WHY CHOOSE US --}}
<section class="relative py-24 bg-slate-50/40 overflow-hidden" id="why-choose-us">
    {{-- FLOATING CLOUDS & MASCOT DECORATIONS (LEFT) --}}
    <div class="absolute top-[10%] left-[2%] sm:left-[4%] floating-cloud pointer-events-none">
        <img src="{{ asset('assets/maskot/awan 1.png') }}" alt="Cloud">
    </div>
    <div class="absolute top-[42%] left-[1.5%] sm:left-[3%] floating-cloud floating-cloud-mascot pointer-events-none" style="animation-delay: 1.5s;">
        <img src="{{ asset('assets/maskot/pen maskot.png') }}" alt="Owl Pen Mascot" class="drop-shadow-md">
    </div>
    <div class="absolute bottom-[12%] left-[2%] sm:left-[5%] floating-cloud pointer-events-none" style="animation-delay: 3s;">
        <img src="{{ asset('assets/maskot/awan 3.png') }}" alt="Cloud">
    </div>

    {{-- FLOATING CLOUDS & MASCOT DECORATIONS (RIGHT) --}}
    <div class="absolute top-[15%] right-[2%] sm:right-[4%] floating-cloud pointer-events-none" style="animation-delay: 2s;">
        <img src="{{ asset('assets/maskot/awan 5.png') }}" alt="Cloud">
    </div>
    <div class="absolute top-[48%] right-[1.5%] sm:right-[3%] floating-cloud floating-cloud-mascot pointer-events-none" style="animation-delay: 0.5s;">
        <img src="{{ asset('assets/maskot/pricing maskot.png') }}" alt="Owl Target Mascot" class="drop-shadow-md">
    </div>
    <div class="absolute bottom-[18%] right-[2%] sm:right-[5%] floating-cloud pointer-events-none" style="animation-delay: 4.5s;">
        <img src="{{ asset('assets/maskot/awan 4.png') }}" alt="Cloud">
    </div>

    <div class="max-w-[1200px] mx-auto px-[5%] relative z-10">
        <div class="text-center mb-16">
            <span class="bg-blue-50 text-blue-600 px-4 py-1.5 rounded-full text-xs font-bold mb-6 inline-block uppercase tracking-widest">
                Why Choose Us
            </span>
            <h2 class="text-4xl lg:text-5xl font-extrabold text-[#1a3a5a] mb-6 leading-[1.1]">
                All-in-one platform for English <br class="hidden md:block"> learning and test preparation 
            </h2>
        </div>

        {{-- BENTO GRID BOARD --}}
        <div class="puzzle-board">
            {{-- ROW 1 --}}
            {{-- TOEIC --}}
            <div class="feature-card f-toeic">
                <div class="feature-icon-wrapper">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <h3>TOEIC Preparation</h3>
                <p>Focus on workplace communication skills, including business conversations, emails, and daily office situations. Suitable for career preparation and corporate environments.</p>
            </div>

            {{-- TOEFL --}}
            <div class="feature-card f-toefl">
                <div class="feature-icon-wrapper">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 14v7" />
                    </svg>
                </div>
                <h3>TOEFL Preparation</h3>
                <p>Focuses on academic English used in universities, including lectures, essays, and campus discussions. Widely accepted for international education.</p>
            </div>

            {{-- IELTS --}}
            <div class="feature-card f-ielts">
                <div class="feature-icon-wrapper">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                    </svg>
                </div>
                <h3>IELTS Preparation</h3>
                <p>Designed for academic and international purposes, covering listening, reading, writing, and speaking. Commonly required for studying or working abroad.</p>
            </div>

            {{-- ROW 2 --}}
            {{-- LEARNING PROGRESS --}}
            <div class="feature-card f-progress">
                <div class="feature-icon-wrapper">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 002 2h2a2 2 0 002-2" />
                    </svg>
                </div>
                <h3>Learning Progress</h3>
                <p>Track your learning journey with detailed statistics, module completion rates, and study time analytics to keep you motivated.</p>
            </div>

            {{-- LMS --}}
            <div class="feature-card f-lms">
                <div class="feature-icon-wrapper">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <h3>LMS Platform</h3>
                <p>A flexible learning system to track progress, access materials, and improve English skills at your own pace.</p>
            </div>

            {{-- MOCK TEST & CERTIFICATE --}}
            <div class="feature-card f-certificate">
                <div class="feature-icon-wrapper">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                    </svg>
                </div>
                <h3>Mock Test & Certificate</h3>
                <p>Practice with real exam simulations, receive instant score reports, and earn digital certificates upon course completion.</p>
            </div>
        </div>
    </div>
</section>
