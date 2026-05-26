
    <div class="py-10 bg-white border-t border-b border-slate-100 mt-12">
        <div class="max-w-[1100px] mx-auto px-[5%]">
            <div class="stats-grid grid grid-cols-2 lg:grid-cols-4 gap-6 text-center">
                @foreach([
                    ['250', 'K +', 'Premium Courses'],
                    ['500', 'K+',  'Active Learner'],
                    ['98',  '%',   'Pass Rate'],
                    ['100', 'K+',  'Certificates Issued'],
                ] as $stat)
                <div class="flex flex-col items-center">
                    <div class="text-2xl lg:text-3xl font-extrabold text-[#1a3a5a] mb-1">
                        <span class="counter" data-target="{{ $stat[0] }}">0</span>{{ $stat[1] }}
                    </div>
                    <div class="text-[10px] lg:text-[11px] font-bold text-[#1a3a5a] uppercase tracking-widest opacity-70">{{ $stat[2] }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </div>