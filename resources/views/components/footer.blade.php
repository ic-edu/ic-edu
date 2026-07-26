<footer class="bg-[#1a3a5a] px-[5%] pt-20 pb-8 text-white relative overflow-hidden">
    <!-- Subtle background decorations for premium feel -->
    <div class="absolute -top-24 -left-24 w-96 h-96 rounded-full bg-blue-600/10 blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-24 -right-24 w-96 h-96 rounded-full bg-indigo-600/10 blur-3xl pointer-events-none"></div>

    <div class="max-w-[1160px] mx-auto relative z-10">

        {{-- Top Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-12 pb-16 mb-8 border-b border-white/10">

            {{-- Brand Section --}}
            <div class="flex flex-col gap-4">
                <img src="{{ asset(config('tenant.active.logo_auth')) }}" 
                     alt="IC.edu" 
                     class="h-[40px] w-auto object-contain self-start">
                <p class="text-sm leading-relaxed max-w-[280px] !text-slate-300 font-medium">
                    iC.Edu is a global online learning platform that helps you gain in-demand language skills to advance in your career.
                </p>
            </div>

            {{-- Office Section --}}
            <div class="flex flex-col gap-4">
                <h5 class="text-sm font-bold uppercase tracking-wider !text-white">Office</h5>
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-blue-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <p class="text-sm !text-slate-300 leading-relaxed">Jl. Cilengkrang 1, Palasari</p>
                </div>
            </div>

            {{-- Contact Section --}}
            <div class="flex flex-col gap-4">
                <h5 class="text-sm font-bold uppercase tracking-wider !text-white">Contact</h5>
                <div class="flex flex-col gap-4">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-blue-400 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <a href="mailto:ic.edu.bdg@gmail.com" class="text-sm !text-slate-300 hover:text-white transition-colors">ic.edu.bdg@gmail.com</a>
                    </div>
                    
                    {{-- Social Icons --}}
                    <div class="flex items-center gap-3 mt-2">
                        {{-- WhatsApp --}}
                        <a href="0851-6309-1929" class="w-9 h-9 rounded-full bg-white/5 hover:bg-[#25D366] text-slate-300 hover:text-white flex items-center justify-center transition-all duration-300 hover:-translate-y-1" aria-label="WhatsApp">
                            <svg class="w-4.5 h-4.5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L0 24l6.335-1.662c1.72.937 3.659 1.432 5.628 1.433h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                            </svg>
                        </a>

                        {{-- Facebook --}}
                        <a href="#" class="w-9 h-9 rounded-full bg-white/5 hover:bg-[#1877F2] text-slate-300 hover:text-white flex items-center justify-center transition-all duration-300 hover:-translate-y-1" aria-label="Facebook">
                            <svg class="w-4.5 h-4.5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.469h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>

                        {{-- Instagram --}}
                        <a target="_blank" href="https://www.instagram.com/ic.edu.official_" class="w-9 h-9 rounded-full bg-white/5 hover:bg-[#E1306C] text-slate-300 hover:text-white flex items-center justify-center transition-all duration-300 hover:-translate-y-1" aria-label="Instagram">
                            <svg class="w-4.5 h-4.5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.668-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>
                            </svg>
                        </a>

                        {{-- LinkedIn --}}
                        <a href="#" class="w-9 h-9 rounded-full bg-white/5 hover:bg-[#0A66C2] text-slate-300 hover:text-white flex items-center justify-center transition-all duration-300 hover:-translate-y-1" aria-label="LinkedIn">
                            <svg class="w-4.5 h-4.5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Explore Section --}}
            <div class="flex flex-col gap-4">
                <h5 class="text-sm font-bold uppercase tracking-wider !text-white">Explore</h5>
                <div class="flex flex-col gap-2.5">
                    @foreach(['TOEIC', 'TOEFL', 'IELTS', 'LMS'] as $item)
                        <a href="#" class="text-sm !text-slate-300 hover:text-white transition-colors duration-200 flex items-center gap-1.5 group">
                            <span class="w-1.5 h-1.5 rounded-full bg-blue-400 scale-0 group-hover:scale-100 transition-transform duration-200"></span>
                            <span>{{ $item }}</span>
                        </a>
                    @endforeach
                </div>
            </div>

        </div>

        {{-- Bottom Bar --}}
        <div class="text-center pt-4">
            <p class="text-xs !text-slate-400 tracking-wider">
                2026 iC.Edu Copyright
            </p>    
        </div>

    </div>
</footer>