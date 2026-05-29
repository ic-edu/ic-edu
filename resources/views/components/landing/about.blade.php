{{-- SECTION 2 - About --}}
<section class="relative bg-[#1a395b] w-[100vw] left-1/2 right-1/2 -ml-[50vw] -mr-[50vw] pt-16 pb-16 lg:pt-24 lg:pb-24 px-[5%] rounded-t-[30px] sm:rounded-t-[50px] lg:rounded-t-[80px] overflow-hidden">
    <div class="max-w-[1140px] mx-auto flex flex-col lg:flex-row items-center gap-12 lg:gap-16 relative z-10">
        <div class="w-full lg:w-[45%] flex justify-center lg:justify-start" data-aos="fade-right" data-aos-duration="1000">
            <div class="relative w-full max-w-[380px] aspect-[4/5] mt-4 ml-4">
                <!-- SVG Clip Path Definition -->
                <svg width="0" height="0" class="absolute pointer-events-none">
                    <defs>
                        <clipPath id="card-clip" clipPathUnits="objectBoundingBox">
                            <path d="M 0.22 0 L 0.92 0 Q 1 0 1 0.08 L 1 0.92 Q 1 1 0.92 1 L 0.08 1 Q 0 1 0 0.92 L 0 0.22 L 0.22 0 Z" />
                        </clipPath>
                    </defs>
                </svg>

                <!-- Backing Card (Offset) -->
                <div class="absolute inset-0 -translate-x-4 -translate-y-4 bg-white/15 backdrop-blur-sm pointer-events-none" style="clip-path: url(#card-clip);"></div>

                <!-- Main Image Card -->
                <div class="w-full h-full bg-slate-800 shadow-2xl" style="clip-path: url(#card-clip);">
                    <img src="{{ asset('assets/building.png') }}" 
                         alt="PT Edukasi Persada Indonesia Building" 
                         class="w-full h-full object-cover transition-transform duration-500 hover:scale-105">
                </div>
            </div>
        </div>

        <div class="w-full lg:w-[55%] text-white" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200">
            <div class="mb-6 flex justify-center lg:justify-start">
                <span class="inline-block bg-white text-[#1a395b] text-xs font-semibold px-4 py-1.5 rounded-full tracking-wide">
                    Who we are - Who we are
                </span>
            </div>
            
            <h2 class="text-3xl sm:text-4xl lg:text-[40px] font-extrabold leading-tight mb-6 tracking-tight text-center lg:text-left !text-white">
                Your Trusted Platform for English Learning<br class="hidden sm:block">
                and Test Preparation
            </h2>
            
            <p class="text-sm lg:text-base !text-white leading-relaxed mb-8 max-w-[580px] text-center lg:text-left">
                IC Edu is an English education platform operated by <strong class="!text-white">PT Edukasi Persada Indonesia</strong>, providing tailored language training programs for students, professionals, universities, and companies.
            </p>
            <div class="space-y-6 max-w-[500px] mx-auto lg:mx-0">
                {{-- Point 1 --}}
                <div class="flex items-start gap-4">
                    <span class="!text-white text-2xl leading-none mt-0.5">•</span>
                    <div>
                        <h4 class="text-base font-bold !text-white leading-tight mb-1">Interactive Practice</h4>
                        <p class="text-sm !text-white/90">Engaging modules and real test simulations</p>
                    </div>
                </div>

                {{-- Point 2 --}}
                <div class="flex items-start gap-4">
                    <span class="!text-white text-2xl leading-none mt-0.5">•</span>
                    <div>
                        <h4 class="text-base font-bold !text-white leading-tight mb-1">International Preparation</h4>
                        <p class="text-sm !text-white/90">Programs for IELTS, TOEFL, and TOEIC success.</p>
                    </div>
                </div>

                {{-- Point 3 --}}
                <div class="flex items-start gap-4">
                    <span class="!text-white text-2xl leading-none mt-0.5">•</span>
                    <div>
                        <h4 class="text-base font-bold !text-white leading-tight mb-1">Flexible Learning</h4>
                        <p class="text-sm !text-white/90">Study anytime through our digital platform.</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
