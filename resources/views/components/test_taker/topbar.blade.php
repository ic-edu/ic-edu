<header class="topbar">
    <div class="topbar-left">
        <h1 class="font-heading text-xl font-extrabold text-slate-800 flex items-center gap-2 leading-none">
            Welcome back, {{ explode(' ', auth()->user()->name ?? 'Student')[0] }} 
            <span class="wave-emoji text-2xl">👋</span>
        </h1>
        <!-- <p class="text-sm text-slate-500 font-medium mt-1">Let's learn something new today!</p> -->
    </div>

    <div class="topbar-right flex items-center gap-3 lg:gap-4">

        <button class="notif-btn" onclick="openNotifPanel()" aria-label="Open notifications">
            <x-lucide-bell class="w-5 h-5" />
            <div class="notif-badge"></div>
        </button>
        
    </div>

</header>