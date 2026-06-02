@push('styles')
<style>
    /* ── Testimonial scrolling columns ── */
    .testi-col-wrap {
        overflow: hidden;
        mask-image: linear-gradient(to bottom, transparent 0%, black 10%, black 90%, transparent 100%);
        -webkit-mask-image: linear-gradient(to bottom, transparent 0%, black 10%, black 90%, transparent 100%);
    }

    .testi-track {
        display: flex;
        flex-direction: column;
        gap: 16px;
        animation-timing-function: linear;
        animation-iteration-count: infinite;
    }

    .testi-track-up {
        animation: testiScrollUp 30s linear infinite;
    }

    .testi-track-down {
        animation: testiScrollDown 35s linear infinite;
    }

    .testi-col-wrap:hover .testi-track {
        animation-play-state: paused;
    }

    @keyframes testiScrollUp {
        0% { transform: translateY(0); }
        100% { transform: translateY(-50%); }
    }

    @keyframes testiScrollDown {
        0% { transform: translateY(-50%); }
        100% { transform: translateY(0); }
    }

    .testi-item {
        background: #fff;
        border: 1px solid #e8edf4;
        border-radius: 20px;
        padding: 22px;
        flex-shrink: 0;
        transition: box-shadow .25s ease, transform .25s ease;
        cursor: default;
    }

    .testi-item:hover {
        box-shadow: 0 16px 48px rgba(37, 99, 235, 0.10);
        transform: translateY(-3px);
    }

    /* Gaya tulisan header testimonial */
    .testi-title {
        font-family: 'Poppins', sans-serif;
        color: #1a3a5a;
        font-weight: 800;
        line-height: 1.1;
    }
</style>
@endpush

{{-- SECTION 7 — TESTIMONIALS + STATISTIC BAR --}}
<section class="testi-section py-24 overflow-hidden bg-white" id="testimonials">
    <div class="max-w-[1200px] mx-auto px-[5%]">
        @php
        $displayColA = [
            ['name' => 'Arran Douglas', 'achievement' => 'IELTS Score: 7.5 → 8.0', 'quote' => 'The modules at IC.EDU were very easy to understand. The LMS monitored my progress every day.'],
            ['name' => 'Jeffrey Avery', 'achievement' => 'TOEFL iBT: 89 → 107', 'quote' => 'I really enjoyed the online test platform. The interface has a simple, fast, and the UI/UX is comfortable.']
        ];

        $displayColB = [
            ['name' => 'Amanda Banks', 'achievement' => 'Business English Certified', 'quote' => 'This platform made my English preparation more effective. The results were beyond my expectations.']
        ];
        @endphp
        <div class="grid lg:grid-cols-[400px_1fr] gap-16 items-center">
            <div class="text-center lg:text-left">
                <div class="mb-6 flex justify-center lg:justify-start">
                    <svg class="text-[#1a3a5a]" width="60" height="45" viewBox="0 0 80 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M22.8571 0V30H0V60H34.2857V0H22.8571ZM68.5714 0V30H45.7143V60H80V0H68.5714Z" fill="currentColor" />
                    </svg>
                </div>
                <h2 class="testi-title text-4xl lg:text-5xl mb-6">
                    Stories from<br>IC.EDU<br>Learners
                </h2>
                <p class="text-slate-500 text-lg max-w-[320px] mx-auto lg:mx-0">Read what our students have to say about their journey.</p>
            </div>
            
            {{-- Desktop Testimonials Track --}}
            <div class="hidden lg:grid grid-cols-2 gap-6" style="height: 600px;">
                <div class="testi-col-wrap">
                    <div class="testi-track testi-track-up">
                        @foreach(array_merge($displayColA, $displayColA, $displayColA) as $t)
                        <div class="bg-white border border-slate-100 p-8 rounded-[32px] shadow-sm">
                            <div class="text-amber-400 mb-4 text-sm">★★★★★</div>
                            <p class="text-slate-600 mb-6 italic">"{{ $t['quote'] }}"</p>
                            <div class="flex items-center gap-4">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($t['name']) }}&background=1a3a5a&color=fff" class="w-11 h-11 rounded-full">
                                <div>
                                    <div class="font-bold text-[#1a3a5a] text-sm">{{ $t['name'] }}</div>
                                    <div class="text-xs text-slate-400">{{ $t['achievement'] }}</div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="testi-col-wrap mt-12">
                    <div class="testi-track testi-track-down">
                        @foreach(array_merge($displayColB, $displayColB, $displayColB) as $t)
                        <div class="bg-white border border-slate-100 p-8 rounded-[32px] shadow-sm">
                            <div class="text-amber-400 mb-4 text-sm">★★★★★</div>
                            <p class="text-slate-600 mb-6 italic">"{{ $t['quote'] }}"</p>
                            <div class="flex items-center gap-4">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($t['name']) }}&background=1a3a5a&color=fff" class="w-11 h-11 rounded-full">
                                <div>
                                    <div class="font-bold text-[#1a3a5a] text-sm">{{ $t['name'] }}</div>
                                    <div class="text-xs text-slate-400">{{ $t['achievement'] }}</div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Mobile Testimonials List --}}
            <div class="block lg:hidden mt-8 space-y-6">
                @foreach(array_merge($displayColA, $displayColB) as $t)
                <div class="bg-white border border-slate-100 p-6 rounded-[24px] shadow-sm">
                    <div class="text-amber-400 mb-3 text-sm">★★★★★</div>
                    <p class="text-slate-600 mb-4 italic text-sm">"{{ $t['quote'] }}"</p>
                    <div class="flex items-center gap-3">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($t['name']) }}&background=1a3a5a&color=fff" class="w-9 h-9 rounded-full">
                        <div>
                            <div class="font-bold text-[#1a3a5a] text-xs">{{ $t['name'] }}</div>
                            <div class="text-[10px] text-slate-400">{{ $t['achievement'] }}</div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    
    <div class="py-10 bg-white border-t border-b border-slate-100 mt-12">
        <div class="max-w-[1100px] mx-auto px-[5%]">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 text-center">
                <div class="flex flex-col items-center">
                    <div class="text-2xl lg:text-3xl font-extrabold text-[#1a3a5a] mb-1">
                        <span class="counter" data-target="250">0</span>K +
                    </div>
                    <div class="text-[10px] lg:text-[11px] font-bold text-[#1a3a5a] uppercase tracking-widest opacity-70">Premium Courses</div>
                </div>
                <div class="flex flex-col items-center">
                    <div class="text-2xl lg:text-3xl font-extrabold text-[#1a3a5a] mb-1">
                        <span class="counter" data-target="500">0</span>K+
                    </div>
                    <div class="text-[10px] lg:text-[11px] font-bold text-[#1a3a5a] uppercase tracking-widest opacity-70">Active Learner</div>
                </div>
                <div class="flex flex-col items-center">
                    <div class="text-2xl lg:text-3xl font-extrabold text-[#1a3a5a] mb-1">
                        <span class="counter" data-target="98">0</span>%
                    </div>
                    <div class="text-[10px] lg:text-[11px] font-bold text-[#1a3a5a] uppercase tracking-widest opacity-70">Pass Rate</div>
                </div>
                <div class="flex flex-col items-center">
                    <div class="text-2xl lg:text-3xl font-extrabold text-[#1a3a5a] mb-1">
                        <span class="counter" data-target="100">0</span>K+
                    </div>
                    <div class="text-[10px] lg:text-[11px] font-bold text-[#1a3a5a] uppercase tracking-widest opacity-70">Certificates Issued</div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    (function() {
        const counters = document.querySelectorAll('.counter');
        const speed = 200;

        const startCounter = (entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const target = +entry.target.getAttribute('data-target');
                    const updateCount = () => {
                        const currentCount = +entry.target.innerText;
                        const increment = target / speed;
                        if (currentCount < target) {
                            if (target % 1 !== 0) {
                                entry.target.innerText = (currentCount + increment).toFixed(1);
                            } else {
                                entry.target.innerText = Math.ceil(currentCount + increment);
                            }
                            setTimeout(updateCount, 1);
                        } else {
                            entry.target.innerText = target;
                        }
                    };
                    updateCount();
                    observer.unobserve(entry.target);
                }
            });
        };

        const observer = new IntersectionObserver(startCounter, { threshold: 0.5 });
        counters.forEach(counter => observer.observe(counter));
    })();
</script>
@endpush
