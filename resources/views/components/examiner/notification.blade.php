@php
    $examinerNotifications = auth()->user()
        ? auth()->user()->notifications()->latest()->limit(8)->get()
        : collect();

    $examinerUnreadCount = auth()->user()
        ? auth()->user()->unreadNotifications()->count()
        : 0;
@endphp

<div id="examinerNotificationPanel"
    class="fixed right-8 top-28 z-[9999] hidden w-[380px] max-w-[calc(100vw-3rem)] overflow-hidden rounded-[28px] bg-white shadow-2xl border border-slate-100">

    <div class="flex items-center justify-between border-b border-slate-100 px-6 py-5">
        <div class="flex items-center gap-3">
            <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-blue-50 text-blue-900">
                🔔
            </div>

            <div>
                <h3 class="text-base font-bold text-slate-900">
                    Examiner Notifications
                </h3>

                <p class="text-xs text-slate-400">
                    {{ $examinerUnreadCount > 0 ? $examinerUnreadCount . ' unread notification(s)' : 'All caught up!' }}
                </p>
            </div>
        </div>

        <button type="button"
            onclick="document.getElementById('examinerNotificationPanel').classList.add('hidden')"
            class="flex h-9 w-9 items-center justify-center rounded-xl text-slate-400 hover:bg-slate-100 hover:text-slate-700 transition">
            ✕
        </button>
    </div>

    <div class="flex items-center gap-2 border-b border-slate-100 px-6 py-3">
        <button class="rounded-xl bg-blue-900 px-4 py-2 text-xs font-bold text-white">
            All
        </button>

        <button class="rounded-xl bg-slate-50 px-4 py-2 text-xs font-bold text-slate-500">
            Unread
        </button>

        <button class="rounded-xl bg-slate-50 px-4 py-2 text-xs font-bold text-slate-500">
            Grading
        </button>
    </div>

    <div class="max-h-[420px] overflow-y-auto">
        @forelse($examinerNotifications as $notification)
            <div class="border-b border-slate-100 px-6 py-4 last:border-b-0 {{ is_null($notification->read_at) ? 'bg-blue-50/40' : 'bg-white' }}">
                <div class="flex gap-3">
                    <div class="mt-1 flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-900">
                        📋
                    </div>

                    <div class="min-w-0">
                        <p class="text-sm font-bold text-slate-900">
                            {!! $notification->data['title'] ?? 'New Notification' !!}
                        </p>

                        <p class="mt-1 text-xs leading-5 text-slate-500">
                            {!! $notification->data['desc'] ?? 'You have a new update.' !!}
                        </p>

                        <div class="mt-3 flex items-center justify-between gap-3">
                            <p class="text-[11px] text-slate-400">
                                {{ $notification->created_at?->diffForHumans() }}
                            </p>

                            @if(!empty($notification->data['action_url']))
                                <a href="{{ $notification->data['action_url'] }}"
                                    class="text-[11px] font-bold text-blue-900 hover:underline">
                                    {{ $notification->data['action_text'] ?? 'Open →' }}
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="px-6 py-12 text-center">
                <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-50 text-3xl">
                    🔕
                </div>

                <h4 class="font-bold text-slate-800">
                    No notifications yet
                </h4>

                <p class="mt-1 text-sm text-slate-500">
                    Grading assignments and system updates will appear here.
                </p>
            </div>
        @endforelse
    </div>
</div>

<script>
    document.addEventListener('click', function (event) {
        const panel = document.getElementById('examinerNotificationPanel');
        const trigger = event.target.closest('.examiner-notification-trigger');

        if (!panel) return;

        if (trigger) {
            event.preventDefault();
            panel.classList.toggle('hidden');
            return;
        }

        if (!panel.contains(event.target)) {
            panel.classList.add('hidden');
        }
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            const panel = document.getElementById('examinerNotificationPanel');
            if (panel) panel.classList.add('hidden');
        }
    });
</script>