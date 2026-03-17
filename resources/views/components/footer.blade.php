<footer class="bg-slate-900 px-[5%] pt-16 pb-8">
    <div class="max-w-[1160px] mx-auto">

        {{-- Top Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-12 pb-12 border-b border-white/10 mb-8">

            {{-- Brand --}}
            <div>
                <img src="{{ asset('assets/ic_edu_logo.png') }}"
                     alt="IC EDU"
                     class="h-[34px] mb-4 brightness-[10]">
                <p class="text-sm text-white/45 leading-7 max-w-[240px]">
                    IC.EDU is a global online learning platform that helps you gain in-demand language skills to advance in your career.
                </p>
            </div>

            {{-- Explore --}}
            <div>
                <h5 class="text-xs font-bold text-white uppercase tracking-widest mb-4">Explore</h5>
                @foreach(['Home', 'Courses', 'Mentors', 'Community', 'Pricing'] as $link)
                    <a href="#" class="block text-sm text-white/45 hover:text-white/85 mb-[0.65rem] transition-colors">
                        {{ $link }}
                    </a>
                @endforeach
            </div>

            {{-- Company --}}
            <div>
                <h5 class="text-xs font-bold text-white uppercase tracking-widest mb-4">Company</h5>
                @foreach(['About Us', 'Blog', 'Press', 'Careers', 'Contact'] as $link)
                    <a href="#" class="block text-sm text-white/45 hover:text-white/85 mb-[0.65rem] transition-colors">
                        {{ $link }}
                    </a>
                @endforeach
            </div>

            {{-- Support --}}
            <div>
                <h5 class="text-xs font-bold text-white uppercase tracking-widest mb-4">Support</h5>
                @foreach(['Help Center', 'Terms of Service', 'Privacy Policy', 'Cookie Settings', 'Scholarships'] as $link)
                    <a href="#" class="block text-sm text-white/45 hover:text-white/85 mb-[0.65rem] transition-colors">
                        {{ $link }}
                    </a>
                @endforeach
            </div>

        </div>

        {{-- Bottom Bar --}}
        <div class="flex flex-wrap items-center justify-between gap-2 text-xs text-white/30">
            <span>© {{ date('Y') }} IC.EDU. All rights reserved.</span>
            <span>Made with ❤️ for English learners everywhere</span>
        </div>

    </div>
</footer>