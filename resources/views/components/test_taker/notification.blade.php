{{-- ============================================================
     NOTIFICATION PANEL — Test Taker
     Usage: <x-test-taker.notification />
     Opened/closed by notif-btn in topbar.blade.php
     ============================================================ --}}

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
                <p class="np__subtitle">4 unread messages</p>
            </div>
        </div>
        <div class="np__header-actions">
            <button class="np__mark-all-btn" onclick="markAllRead()">Mark all read</button>
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
        <button class="np__tab" onclick="filterNotif(this, 'unread')">Unread <span class="np__tab-badge">4</span></button>
        <button class="np__tab" onclick="filterNotif(this, 'exam')">Exams</button>
        <button class="np__tab" onclick="filterNotif(this, 'course')">Courses</button>
    </div>

    {{-- Notifications List --}}
    <div class="np__list" id="notif-list">

        {{-- 1. Course Enrollment --}}
        <div class="np__item np__item--unread" data-type="course">
            <div class="np__item-icon np__item-icon--teal">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 10v6M2 10l10-5 10 5-10 5z"/>
                    <path d="M6 12v5c3 3 9 3 12 0v-5"/>
                </svg>
            </div>
            <div class="np__item-body">
                <div class="np__item-header-row">
                    <span class="np__item-category">Course Enrolled</span>
                    <div class="np__unread-dot"></div>
                </div>
                <p class="np__item-title">Successfully enrolled in <strong>IELTS General Training</strong></p>
                <p class="np__item-desc">You've been successfully enrolled. Start your first lesson anytime — your progress is saved automatically.</p>
                <div class="np__item-meta">
                    <span class="np__item-time">
                        <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                        </svg>
                        2 hours ago
                    </span>
                    <a href="#" class="np__item-action">Go to Course →</a>
                </div>
            </div>
        </div>

        {{-- 2. Exam Feedback --}}
        <div class="np__item np__item--unread" data-type="exam">
            <div class="np__item-icon np__item-icon--blue">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                </svg>
            </div>
            <div class="np__item-body">
                <div class="np__item-header-row">
                    <span class="np__item-category">Exam Feedback</span>
                    <div class="np__unread-dot"></div>
                </div>
                <p class="np__item-title">Your <strong>TOEFL Writing Task 2</strong> has been reviewed</p>
                <p class="np__item-desc">Your instructor left detailed feedback on your essay. Score: <span class="np__score-chip">24 / 30</span> — Check the full report for improvement tips.</p>
                <div class="np__item-meta">
                    <span class="np__item-time">
                        <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                        </svg>
                        5 hours ago
                    </span>
                    <a href="#" class="np__item-action">View Feedback →</a>
                </div>
            </div>
        </div>

        {{-- 3. Score Report Ready --}}
        <div class="np__item np__item--unread" data-type="exam">
            <div class="np__item-icon np__item-icon--green">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
                </svg>
            </div>
            <div class="np__item-body">
                <div class="np__item-header-row">
                    <span class="np__item-category">Score Report</span>
                    <div class="np__unread-dot"></div>
                </div>
                <p class="np__item-title">Score report is ready for <strong>TOEIC Listening & Reading</strong></p>
                <p class="np__item-desc">Your full score breakdown is now available. You scored <span class="np__score-chip np__score-chip--high">870 / 990</span> — excellent performance!</p>
                <div class="np__item-meta">
                    <span class="np__item-time">
                        <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                        </svg>
                        Yesterday
                    </span>
                    <a href="#" class="np__item-action">View Report →</a>
                </div>
            </div>
        </div>

        {{-- 4. New Exam Available --}}
        <div class="np__item np__item--unread" data-type="exam">
            <div class="np__item-icon np__item-icon--orange">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/>
                </svg>
            </div>
            <div class="np__item-body">
                <div class="np__item-header-row">
                    <span class="np__item-category">New Exam</span>
                    <div class="np__unread-dot"></div>
                </div>
                <p class="np__item-title">New mock exam added: <strong>IELTS Academic Reading — Set 12</strong></p>
                <p class="np__item-desc">A new practice set is now available in your enrolled course. Test your reading comprehension with authentic passages.</p>
                <div class="np__item-meta">
                    <span class="np__item-time">
                        <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                        </svg>
                        2 days ago
                    </span>
                    <a href="#" class="np__item-action">Start Exam →</a>
                </div>
            </div>
        </div>

        {{-- 5. Exam Reminder (read) --}}
        <div class="np__item" data-type="exam">
            <div class="np__item-icon np__item-icon--purple">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                    <line x1="16" y1="2" x2="16" y2="6"/>
                    <line x1="8" y1="2" x2="8" y2="6"/>
                    <line x1="3" y1="10" x2="21" y2="10"/>
                </svg>
            </div>
            <div class="np__item-body">
                <div class="np__item-header-row">
                    <span class="np__item-category">Reminder</span>
                </div>
                <p class="np__item-title">Don't forget — your <strong>TOEFL Mock Exam</strong> is still in progress</p>
                <p class="np__item-desc">You haven't completed the Speaking section yet. Resume anytime before the deadline on May 28.</p>
                <div class="np__item-meta">
                    <span class="np__item-time">
                        <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                        </svg>
                        3 days ago
                    </span>
                    <a href="#" class="np__item-action">Resume Exam →</a>
                </div>
            </div>
        </div>

        {{-- 6. Achievement Unlocked (read) --}}
        <div class="np__item" data-type="course">
            <div class="np__item-icon np__item-icon--gold">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="8" r="6"/>
                    <path d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11"/>
                </svg>
            </div>
            <div class="np__item-body">
                <div class="np__item-header-row">
                    <span class="np__item-category">Achievement</span>
                </div>
                <p class="np__item-title">You earned the <strong>"First Score"</strong> badge 🎉</p>
                <p class="np__item-desc">Congratulations! You completed your very first graded exam on IC.EDU. Keep going — more badges await!</p>
                <div class="np__item-meta">
                    <span class="np__item-time">
                        <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                        </svg>
                        4 days ago
                    </span>
                </div>
            </div>
        </div>

    </div>

    {{-- Footer --}}
    <div class="np__footer">
        <a href="#" class="np__footer-link">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
            </svg>
            View all notifications
        </a>
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
    document.querySelector('.notif-btn .notif-badge')?.style.setProperty('display', 'none');
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
