@php
    $user = auth()->user();
    $unreadCount = $user ? $user->unreadNotifications->count() : 0;
    $notifications = $user ? $user->notifications()->take(20)->get() : collect();
@endphp

{{-- ── OVERLAY (closes panel on click-outside) ── --}}
<div id="notif-overlay" class="notif-overlay" onclick="closeNotifPanel()"></div>

{{-- ── PANEL ── --}}
<div id="notif-panel" class="notif-panel" role="dialog" aria-label="Notifications" aria-modal="true">

    {{-- Header --}}
    <div class="np__header">
        <div class="np__header-left">
            <div class="np__header-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                    <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
                </svg>
            </div>
            <div>
                <h3 class="np__title">Notifications</h3>
                <p class="np__subtitle">{{ $unreadCount > 0 ? $unreadCount . ' unread message' . ($unreadCount > 1 ? 's' : '') : 'All caught up!' }}</p>
            </div>
        </div>
        <div class="np__header-actions">
            @if($unreadCount > 0)
                <button class="np__mark-all-btn" onclick="markAllRead()">Mark all read</button>
            @endif
            <button class="np__close-btn" onclick="closeNotifPanel()" aria-label="Close notifications">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M18 6 6 18"/><path d="m6 6 12 12"/>
                </svg>
            </button>
        </div>
    </div>

    {{-- Filter Tabs --}}
    <div class="np__tabs">
        <button class="np__tab np__tab--active" onclick="filterNotif(this, 'all')">All</button>
        <button class="np__tab" onclick="filterNotif(this, 'unread')">
            Unread 
            @if($unreadCount > 0)
                <span class="np__tab-badge" id="notif-badge-count">{{ $unreadCount }}</span>
            @endif
        </button>
        <button class="np__tab" onclick="filterNotif(this, 'exam')">Exams</button>
        <button class="np__tab" onclick="filterNotif(this, 'course')">Courses</button>
    </div>

    {{-- Notifications List --}}
    <div class="np__list" id="notif-list">
        @forelse($notifications as $notif)
            @php
                $notifData = $notif->data;
                $isUnread = $notif->unread();
                $type = $notifData['type'] ?? 'course';
                
                // Icon styling based on category
                $category = $notifData['category'] ?? 'Notification';
                $color = 'blue';
                if (str_contains(strtolower($category), 'enroll') || str_contains(strtolower($category), 'course')) {
                    $color = 'teal';
                } elseif (str_contains(strtolower($category), 'cert')) {
                    $color = 'gold';
                } elseif (str_contains(strtolower($category), 'score') || str_contains(strtolower($category), 'grade')) {
                    $color = 'green';
                } elseif (str_contains(strtolower($category), 'submit')) {
                    $color = 'purple';
                }
            @endphp
            <div class="np__item {{ $isUnread ? 'np__item--unread' : '' }}" data-id="{{ $notif->id }}" data-type="{{ $type }}">
                <div class="np__item-icon np__item-icon--{{ $color }}">
                    @if($color === 'teal')
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                    @elseif($color === 'gold')
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11"/></svg>
                    @elseif($color === 'green')
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/><path d="m9 15 2 2 4-4"/></svg>
                    @elseif($color === 'purple')
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                    @endif
                </div>
                <div class="np__item-body">
                    <div class="np__item-header-row">
                        <span class="np__item-category">{{ $category }}</span>
                        @if($isUnread)
                            <div class="np__unread-dot"></div>
                        @endif
                    </div>
                    <p class="np__item-title">{!! $notifData['title'] ?? '' !!}</p>
                    <p class="np__item-desc">{!! $notifData['desc'] ?? '' !!}</p>
                    <div class="np__item-meta">
                        <span class="np__item-time">
                            <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                            </svg>
                            {{ $notif->created_at->diffForHumans() }}
                        </span>
                        @if(!empty($notifData['action_url']))
                            <a href="{{ $notifData['action_url'] }}" class="np__item-action" onclick="markAsRead('{{ $notif->id }}', this)">{{ $notifData['action_text'] ?? 'Go →' }}</a>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-12 px-4">
                <div class="w-12 h-12 bg-slate-50 rounded-2xl flex items-center justify-center mx-auto mb-3 border border-slate-100">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="text-slate-300"><path d="M13.73 21a2 2 0 0 1-3.46 0"/><path d="M18.63 13A17.89 17.89 0 0 1 18 8"/><path d="M6.26 6.26A5.86 5.86 0 0 0 6 8c0 7-3 9-3 9h14"/><path d="m2 2 20 20"/></svg>
                </div>
                <p class="text-sm font-semibold text-slate-500 mb-1">All caught up!</p>
                <p class="text-xs text-slate-400">No new notifications at this time.</p>
            </div>
        @endforelse
    </div>
</div>


<style>
/* ════════════════════════════════════════════════════
   NOTIFICATION PANEL — np__ prefix
════════════════════════════════════════════════════ */

.notif-overlay {
    display: none;
    position: fixed;
    inset: 0;
    z-index: 1000;
    background: transparent;
}

.notif-overlay.is-open {
    display: block;
}

.notif-panel {
    position: fixed;
    top: calc(var(--sidebar-gap) + 76px + 10px);
    right: 32px;
    width: 400px;
    max-height: 600px;
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 20px;
    box-shadow:
        0 4px 6px -1px rgba(0,0,0,0.05),
        0 20px 60px rgba(26, 69, 108, 0.14),
        0 8px 24px rgba(0,0,0,0.06);
    z-index: 1001;
    display: flex;
    flex-direction: column;
    overflow: hidden;

    /* Hidden by default */
    opacity: 0;
    transform: translateY(-10px) scale(0.98);
    pointer-events: none;
    transition: opacity 0.22s cubic-bezier(0.4,0,0.2,1),
                transform 0.22s cubic-bezier(0.4,0,0.2,1);
}

.notif-panel.is-open {
    opacity: 1;
    transform: translateY(0) scale(1);
    pointer-events: all;
}

/* ── Header ── */
.np__header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 18px 20px 14px;
    border-bottom: 1px solid #f1f5f9;
    flex-shrink: 0;
}

.np__header-left {
    display: flex;
    align-items: center;
    gap: 12px;
}

.np__header-icon {
    width: 38px;
    height: 38px;
    border-radius: 12px;
    background: linear-gradient(135deg, #eef3fb, #ddeaf5);
    border: 1px solid #d0e4f0;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #1A456C;
    flex-shrink: 0;
}

.np__title {
    font-size: 15px;
    font-weight: 800;
    color: #0f172a;
    margin: 0;
    font-family: 'Poppins', sans-serif;
    line-height: 1.2;
}

.np__subtitle {
    font-size: 11.5px;
    color: #64748b;
    margin: 2px 0 0;
    font-weight: 500;
}

.np__header-actions {
    display: flex;
    align-items: center;
    gap: 8px;
}

.np__mark-all-btn {
    font-size: 11.5px;
    font-weight: 700;
    color: #1A456C;
    background: #eef3fb;
    border: 1px solid #d0e4f0;
    border-radius: 8px;
    padding: 5px 10px;
    cursor: pointer;
    transition: all 0.18s ease;
    font-family: inherit;
    white-space: nowrap;
}

.np__mark-all-btn:hover {
    background: #1A456C;
    color: white;
    border-color: #1A456C;
}

.np__close-btn {
    width: 30px;
    height: 30px;
    border-radius: 8px;
    background: transparent;
    border: 1px solid transparent;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #94a3b8;
    cursor: pointer;
    transition: all 0.18s ease;
    flex-shrink: 0;
}

.np__close-btn:hover {
    background: #f1f5f9;
    color: #0f172a;
    border-color: #e2e8f0;
}

/* ── Filter Tabs ── */
.np__tabs {
    display: flex;
    gap: 4px;
    padding: 10px 16px;
    border-bottom: 1px solid #f1f5f9;
    flex-shrink: 0;
    background: #fafbfd;
}

.np__tab {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 5px 12px;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 600;
    color: #64748b;
    background: transparent;
    border: none;
    cursor: pointer;
    transition: all 0.18s ease;
    font-family: inherit;
}

.np__tab:hover {
    background: #eef3fb;
    color: #1A456C;
}

.np__tab--active {
    background: #1A456C;
    color: white !important;
}

.np__tab--active:hover {
    background: #1e5a8a;
    color: white;
}

.np__tab-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 17px;
    height: 17px;
    padding: 0 4px;
    border-radius: 99px;
    font-size: 10px;
    font-weight: 800;
    background: #ef4444;
    color: white;
    line-height: 1;
}

.np__tab--active .np__tab-badge {
    background: rgba(255,255,255,0.25);
    color: white;
}

/* ── List ── */
.np__list {
    overflow-y: auto;
    flex: 1;
    padding: 6px 0;
}

.np__list::-webkit-scrollbar {
    width: 3px;
}

.np__list::-webkit-scrollbar-track {
    background: transparent;
}

.np__list::-webkit-scrollbar-thumb {
    background: #e2e8f0;
    border-radius: 99px;
}

/* ── Notification Item ── */
.np__item {
    display: flex;
    gap: 12px;
    padding: 14px 20px;
    cursor: pointer;
    transition: background 0.15s ease;
    border-bottom: 1px solid #f8fafc;
    position: relative;
}

.np__item:last-child {
    border-bottom: none;
}

.np__item:hover {
    background: #f8faff;
}

.np__item--unread {
    background: #fdfeff;
}

.np__item--unread::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 3px;
    background: linear-gradient(to bottom, #1A456C, #6FAFB5);
    border-radius: 0 2px 2px 0;
}

/* ── Item Icon ── */
.np__item-icon {
    width: 38px;
    height: 38px;
    border-radius: 11px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    margin-top: 1px;
}

.np__item-icon--teal   { background: #f0fafb; color: #0e9aa7; border: 1px solid #c8eaec; }
.np__item-icon--blue   { background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; }
.np__item-icon--green  { background: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0; }
.np__item-icon--orange { background: #fff7ed; color: #ea580c; border: 1px solid #fed7aa; }
.np__item-icon--purple { background: #faf5ff; color: #9333ea; border: 1px solid #e9d5ff; }
.np__item-icon--gold   { background: #fffbeb; color: #d97706; border: 1px solid #fde68a; }

/* ── Item Body ── */
.np__item-body {
    flex: 1;
    min-width: 0;
}

.np__item-header-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 4px;
}

.np__item-category {
    font-size: 10px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.07em;
    color: #6FAFB5;
}

.np__unread-dot {
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: #1A456C;
    flex-shrink: 0;
}

.np__item-title {
    font-size: 13px;
    font-weight: 500;
    color: #0f172a;
    margin: 0 0 4px;
    line-height: 1.45;
}

.np__item-title strong {
    font-weight: 700;
    color: #1A456C;
}

.np__item-desc {
    font-size: 12px;
    color: #64748b;
    margin: 0 0 8px;
    line-height: 1.6;
}

.np__score-chip {
    display: inline-flex;
    align-items: center;
    font-size: 11px;
    font-weight: 800;
    background: #fff7ed;
    color: #ea580c;
    border: 1px solid #fed7aa;
    border-radius: 6px;
    padding: 1px 6px;
}

.np__score-chip--high {
    background: #f0fdf4;
    color: #16a34a;
    border-color: #bbf7d0;
}

.np__item-meta {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.np__item-time {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    font-size: 11px;
    color: #94a3b8;
    font-weight: 500;
}

.np__item-action {
    font-size: 11.5px;
    font-weight: 700;
    color: #1A456C;
    text-decoration: none;
    transition: color 0.15s ease;
}

.np__item-action:hover {
    color: #6FAFB5;
    text-decoration: underline;
}

/* ── Footer ── */
.np__footer {
    padding: 12px 20px 14px;
    border-top: 1px solid #f1f5f9;
    display: flex;
    justify-content: center;
    flex-shrink: 0;
    background: #fafbfd;
}

.np__footer-link {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 12.5px;
    font-weight: 700;
    color: #1A456C;
    text-decoration: none;
    padding: 7px 16px;
    border-radius: 9px;
    background: #eef3fb;
    border: 1px solid #d0e4f0;
    transition: all 0.18s ease;
}

.np__footer-link:hover {
    background: #1A456C;
    color: white;
    border-color: #1A456C;
}

/* ── Mobile ── */
@media (max-width: 768px) {
    .notif-panel {
        right: 12px;
        left: 12px;
        width: auto;
        top: 90px;
        max-height: 70vh;
    }

    .notif-overlay.is-open {
        background: rgba(0,0,0,0.2);
        backdrop-filter: blur(2px);
        -webkit-backdrop-filter: blur(2px);
    }
}
</style>


<script>
function openNotifPanel() {
    document.getElementById('notif-panel').classList.add('is-open');
    document.getElementById('notif-overlay').classList.add('is-open');
}

function closeNotifPanel() {
    document.getElementById('notif-panel').classList.remove('is-open');
    document.getElementById('notif-overlay').classList.remove('is-open');
}

function markAllRead() {
    document.querySelectorAll('.np__item--unread').forEach(item => {
        item.classList.remove('np__item--unread');
    });
    document.querySelectorAll('.np__unread-dot').forEach(dot => dot.remove());
    document.querySelector('.np__subtitle').textContent = 'All caught up!';
    document.querySelectorAll('.np__tab-badge').forEach(b => b.style.display = 'none');
    
    // Hide red dot on main hero banner bell if exists
    const heroBadge = document.querySelector('.group\\/notif div');
    if (heroBadge) heroBadge.remove();

    fetch('{{ route('test_taker.notifications.mark_all_read') }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        }
    });
}

function markAsRead(id, element) {
    const item = element.closest('.np__item');
    if (!item || !item.classList.contains('np__item--unread')) return;

    item.classList.remove('np__item--unread');
    const dot = item.querySelector('.np__unread-dot');
    if (dot) dot.remove();

    // Recalculate unread subtitle count
    const unreadCountEl = document.querySelector('#notif-badge-count');
    if (unreadCountEl) {
        let count = parseInt(unreadCountEl.textContent) - 1;
        if (count <= 0) {
            unreadCountEl.style.display = 'none';
            document.querySelector('.np__subtitle').textContent = 'All caught up!';
            const heroBadge = document.querySelector('.group\\/notif div');
            if (heroBadge) heroBadge.remove();
        } else {
            unreadCountEl.textContent = count;
            document.querySelector('.np__subtitle').textContent = count + ' unread message' + (count > 1 ? 's' : '');
        }
    }

    fetch(`/user/notifications/${id}/mark-as-read`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        }
    });
}

function filterNotif(btn, type) {
    // Update active tab
    document.querySelectorAll('.np__tab').forEach(t => t.classList.remove('np__tab--active'));
    btn.classList.add('np__tab--active');

    // Filter items
    document.querySelectorAll('.np__item').forEach(item => {
        if (type === 'all') {
            item.style.display = '';
        } else if (type === 'unread') {
            item.style.display = item.classList.contains('np__item--unread') ? '' : 'none';
        } else {
            item.style.display = (item.dataset.type === type) ? '' : 'none';
        }
    });
}
</script>
