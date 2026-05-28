<aside class="bg-[#f1f5f9] p-6 rounded-2xl border border-slate-100 shadow-sm">
    <h2 class="text-xl font-extrabold text-[#1a456c] mb-1">Filters</h2>
    <p class="text-xs font-semibold text-slate-400 mb-6 uppercase tracking-wider">Target Level</p>

    <div class="flex flex-col gap-2.5" id="level-filters">
        <button class="level-filter-btn flex items-center justify-between w-full px-4 py-2.5 rounded-xl text-left text-sm font-bold bg-[#1a456c] text-white transition-all cursor-pointer" data-filter="all">
            <span>All Levels</span>
        </button>
        
        <button class="level-filter-btn flex items-center justify-between w-full px-4 py-2.5 rounded-xl text-left text-sm font-bold text-slate-600 hover:bg-slate-200 transition-all cursor-pointer" data-filter="beginner">
            <div class="flex items-center gap-2">
                <span class="w-2 h-2 rounded-full" style="background:#059669;"></span>
                <span>Beginner</span>
            </div>
        </button>

        <button class="level-filter-btn flex items-center justify-between w-full px-4 py-2.5 rounded-xl text-left text-sm font-bold text-slate-600 hover:bg-slate-200 transition-all cursor-pointer" data-filter="intermediate">
            <div class="flex items-center gap-2">
                <span class="w-2 h-2 rounded-full" style="background:#d97706;"></span>
                <span>Intermediate</span>
            </div>
        </button>

        <button class="level-filter-btn flex items-center justify-between w-full px-4 py-2.5 rounded-xl text-left text-sm font-bold text-slate-600 hover:bg-slate-200 transition-all cursor-pointer" data-filter="advanced">
            <div class="flex items-center gap-2">
                <span class="w-2 h-2 rounded-full" style="background:#dc2626;"></span>
                <span>Advanced</span>
            </div>
        </button>
    </div>
</aside>
