<div style="max-width:980px;">

    {{-- Page Header --}}
    <div style="margin-bottom:24px;">
        <h1 style="font-size:22px; font-weight:800; color:var(--text); font-family:'Poppins',sans-serif; margin:0 0 4px 0;">Account Settings</h1>
    </div>

    {{-- Flash: profile saved --}}
    @if(session('profile_saved'))
        <div style="display:flex; align-items:center; gap:10px; background:#f0fdf4; border:1px solid #bbf7d0; border-radius:10px; padding:12px 16px; margin-bottom:20px; color:#15803d; font-size:13px; font-weight:600;">
            <x-lucide-check-circle class="w-4 h-4" style="flex-shrink:0;" />
            {{ session('profile_saved') }}
        </div>
    @endif

    {{-- 2-Column Layout --}}
    <div class="tp__profile-grid">

        {{-- ═══════════════════════════════════════
             LEFT COLUMN — Sub-navigation only
        ═══════════════════════════════════════ --}}
        <div>
            <div class="card">
                <div style="padding:10px 10px;">
                    @php
                    $navItems = [
                        ['tab' => 'profile',     'icon' => 'user',    'label' => 'My Profile'],
                        ['tab' => 'password',    'icon' => 'lock',    'label' => 'Password & Security'],
                        ['tab' => 'transactions','icon' => 'receipt', 'label' => 'Transaction History'],
                        ['tab' => 'certificates','icon' => 'award',   'label' => 'Certificates'],
                        ['tab' => 'delete',      'icon' => 'trash-2', 'label' => 'Delete Account', 'danger' => true],
                    ];
                    @endphp

                    @foreach($navItems as $item)
                        @php $isActive = $activeTab === $item['tab']; $isDanger = !empty($item['danger']); @endphp
                        <button
                            wire:click="setTab('{{ $item['tab'] }}')"
                            class="tp__nav-item {{ $isActive ? 'tp__nav-item--active' : '' }} {{ $isDanger ? 'tp__nav-item--danger' : '' }}"
                        >
                            @if($item['icon'] === 'user')        <x-lucide-user     class="tp__nav-icon" />
                            @elseif($item['icon'] === 'lock')    <x-lucide-lock     class="tp__nav-icon" />
                            @elseif($item['icon'] === 'receipt') <x-lucide-receipt  class="tp__nav-icon" />
                            @elseif($item['icon'] === 'award')   <x-lucide-award    class="tp__nav-icon" />
                            @elseif($item['icon'] === 'trash-2') <x-lucide-trash-2  class="tp__nav-icon" />
                            @endif
                            <span>{{ $item['label'] }}</span>
                        </button>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- ═══════════════════════════════════════
             RIGHT COLUMN — Tab content
        ═══════════════════════════════════════ --}}
        <div>

            {{-- ── TAB: MY PROFILE ── --}}
            @if($activeTab === 'profile')

                {{-- CARD 1: Profile Photo --}}
                <div class="card card-pad" style="margin-bottom:16px;">
                    <div style="display:flex; align-items:center; gap:8px; margin-bottom:16px;">
                        <x-lucide-camera style="width:18px; height:18px; color:var(--primary); flex-shrink:0;" />
                        <h2 style="font-size:15px; font-weight:800; color:var(--text); margin:0;">Profile Photo</h2>
                    </div>

                    <div style="display:flex; align-items:center; gap:20px;">
                        <div style="position:relative; flex-shrink:0;">
                            <img
                                src="{{ $user->profile_photo_url }}"
                                alt="{{ $user->name }}"
                                style="width:80px; height:80px; border-radius:50%; object-fit:cover; border:2.5px solid var(--secondary);"
                            >
                            <button
                                wire:click="openPhotoPicker"
                                style="position:absolute; bottom:2px; right:2px; width:26px; height:26px; border-radius:50%; background:var(--primary); border:2px solid white; display:flex; align-items:center; justify-content:center; cursor:pointer;"
                            >
                                <x-lucide-camera style="width:12px; height:12px; color:white;" />
                            </button>
                        </div>

                        <div>
                            <div style="font-size:15px; font-weight:800; color:var(--text); margin-bottom:2px;">{{ $user->name }}</div>
                            <div style="font-size:13px; color:var(--muted); margin-bottom:12px;">{{ $user->email }}</div>
                            <div style="display:flex; align-items:center; gap:10px; flex-wrap:wrap;">
                                <button wire:click="openPhotoPicker" class="tp__btn-outline">Change Photo</button>
                                @if($user->profile_photo)
                                    <button
                                        wire:click="removePhoto"
                                        style="font-size:13px; font-weight:600; background:none; border:none; color:#ef4444; cursor:pointer; padding:6px 0;"
                                        onmouseover="this.style.textDecoration='underline'"
                                        onmouseout="this.style.textDecoration='none'"
                                    >Remove Photo</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- CARD 2: Personal Information --}}
                <div class="card card-pad">
                    <div style="display:flex; align-items:center; gap:8px; margin-bottom:18px;">
                        <x-lucide-user style="width:18px; height:18px; color:var(--primary); flex-shrink:0;" />
                        <h2 style="font-size:15px; font-weight:800; color:var(--text); margin:0;">Personal Information</h2>
                    </div>

                    <div class="tp__form-grid">
                        <div>
                            <label class="tp__label">Full Name *</label>
                            <input type="text" wire:model="name" class="tp__input" placeholder="Your full name">
                            @error('name') <span class="tp__error">⚠ {{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="tp__label">Email Address *</label>
                            <input type="email" wire:model="email" class="tp__input" placeholder="your@email.com">
                            @error('email') <span class="tp__error">⚠ {{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="tp__label">Phone Number</label>
                            <input type="tel" wire:model="phone" class="tp__input" placeholder="+62 8xx xxxx xxxx">
                            @error('phone') <span class="tp__error">⚠ {{ $message }}</span> @enderror
                        </div>
                        {{-- Target Exam dropdown --}}
                        <div>
                            <label class="tp__label">Target Exam</label>
                            <div x-data="{
                                open: false,
                                value: $wire.entangle('target_exam'),
                                options: [
                                    { value: 'TOEIC', label: 'TOEIC', desc: 'Test of English for International Communication' },
                                    { value: 'IELTS', label: 'IELTS', desc: 'International English Language Testing System' },
                                    { value: 'TOEFL', label: 'TOEFL', desc: 'Test of English as a Foreign Language' },
                                ],
                                get selected() { return this.options.find(o => o.value === this.value) ?? null; }
                            }" @click.outside="open = false" class="tp__dd">
                                <button type="button" @click="open = !open" class="tp__dd-btn" :class="{ 'tp__dd-btn--open': open }">
                                    <span x-text="selected ? selected.label : '— Select exam —'" :class="{ 'tp__dd-placeholder': !value }"></span>
                                    <svg class="tp__dd-chevron" :style="open ? 'transform:rotate(180deg)' : ''" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9l6 6 6-6"/></svg>
                                </button>
                                <div x-show="open" x-transition class="tp__dd-panel" style="display:none;">
                                    <template x-for="opt in options" :key="opt.value">
                                        <button type="button" @click="value = opt.value; open = false" class="tp__dd-item" :class="{ 'tp__dd-item--active': value === opt.value }">
                                            <div class="tp__dd-item-body">
                                                <span class="tp__dd-item-label" x-text="opt.label"></span>
                                                <span class="tp__dd-item-desc" x-text="opt.desc"></span>
                                            </div>
                                            <svg x-show="value === opt.value" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;"><path d="M20 6L9 17l-5-5"/></svg>
                                        </button>
                                    </template>
                                </div>
                            </div>
                            @error('target_exam') <span class="tp__error">⚠ {{ $message }}</span> @enderror
                        </div>

                        {{-- English Level dropdown --}}
                        <div>
                            <label class="tp__label">English Level</label>
                            <div x-data="{
                                open: false,
                                value: $wire.entangle('english_level'),
                                options: [
                                    { value: 'beginner',     label: 'Beginner',     dot: '#059669' },
                                    { value: 'intermediate', label: 'Intermediate', dot: '#d97706' },
                                    { value: 'advanced',     label: 'Advanced',     dot: '#dc2626' },
                                ],
                                get selected() { return this.options.find(o => o.value === this.value) ?? null; }
                            }" @click.outside="open = false" class="tp__dd">
                                <button type="button" @click="open = !open" class="tp__dd-btn" :class="{ 'tp__dd-btn--open': open }">
                                    <span style="display:flex; align-items:center; gap:8px;">
                                        <span x-show="selected" class="tp__dd-dot" :style="'background:' + (selected?.dot ?? '')"></span>
                                        <span x-text="selected ? selected.label : '— Select level —'" :class="{ 'tp__dd-placeholder': !value }"></span>
                                    </span>
                                    <svg class="tp__dd-chevron" :style="open ? 'transform:rotate(180deg)' : ''" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9l6 6 6-6"/></svg>
                                </button>
                                <div x-show="open" x-transition class="tp__dd-panel" style="display:none;">
                                    <template x-for="opt in options" :key="opt.value">
                                        <button type="button" @click="value = opt.value; open = false" class="tp__dd-item" :class="{ 'tp__dd-item--active': value === opt.value }">
                                            <span style="display:flex; align-items:center; gap:10px;">
                                                <span class="tp__dd-dot" :style="'background:' + opt.dot"></span>
                                                <span class="tp__dd-item-label" x-text="opt.label"></span>
                                            </span>
                                            <svg x-show="value === opt.value" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;"><path d="M20 6L9 17l-5-5"/></svg>
                                        </button>
                                    </template>
                                </div>
                            </div>
                            @error('english_level') <span class="tp__error">⚠ {{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="tp__label">Target Score</label>
                            <input type="number" wire:model="target_score" min="0" class="tp__input" placeholder="e.g. 750">
                            @error('target_score') <span class="tp__error">⚠ {{ $message }}</span> @enderror
                        </div>
                        <div style="grid-column:1/-1;">
                            <label class="tp__label">Short Bio</label>
                            <textarea wire:model="profile_bio" class="tp__input" rows="3" placeholder="Tell others a little about yourself..." style="resize:vertical;"></textarea>
                            @error('profile_bio') <span class="tp__error">⚠ {{ $message }}</span> @enderror
                        </div>
                        {{-- Learning Purpose dropdown --}}
                        <div style="grid-column:1/-1;">
                            <label class="tp__label">Learning Purpose</label>
                            <div x-data="{
                                open: false,
                                value: $wire.entangle('learning_purpose'),
                                options: [
                                    { value: 'career',       label: 'Career',       desc: 'For work and professional growth',   icon: '💼' },
                                    { value: 'study_abroad', label: 'Study Abroad', desc: 'For university or exchange program', icon: '🎓' },
                                    { value: 'personal',     label: 'Personal',     desc: 'For travel or personal enrichment',  icon: '✈️' },
                                    { value: 'other',        label: 'Other',        desc: 'Other learning goals',               icon: '💡' },
                                ],
                                get selected() { return this.options.find(o => o.value === this.value) ?? null; }
                            }" @click.outside="open = false" class="tp__dd">
                                <button type="button" @click="open = !open" class="tp__dd-btn" :class="{ 'tp__dd-btn--open': open }">
                                    <span style="display:flex; align-items:center; gap:8px;">
                                        <span x-show="selected" x-text="selected?.icon" style="font-size:15px; line-height:1;"></span>
                                        <span x-text="selected ? selected.label : '— Select purpose —'" :class="{ 'tp__dd-placeholder': !value }"></span>
                                    </span>
                                    <svg class="tp__dd-chevron" :style="open ? 'transform:rotate(180deg)' : ''" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9l6 6 6-6"/></svg>
                                </button>
                                <div x-show="open" x-transition class="tp__dd-panel" style="display:none;">
                                    <template x-for="opt in options" :key="opt.value">
                                        <button type="button" @click="value = opt.value; open = false" class="tp__dd-item" :class="{ 'tp__dd-item--active': value === opt.value }">
                                            <span style="display:flex; align-items:center; gap:12px;">
                                                <span x-text="opt.icon" class="tp__dd-item-icon"></span>
                                                <span class="tp__dd-item-body">
                                                    <span class="tp__dd-item-label" x-text="opt.label"></span>
                                                    <span class="tp__dd-item-desc" x-text="opt.desc"></span>
                                                </span>
                                            </span>
                                            <svg x-show="value === opt.value" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;"><path d="M20 6L9 17l-5-5"/></svg>
                                        </button>
                                    </template>
                                </div>
                            </div>
                            @error('learning_purpose') <span class="tp__error">⚠ {{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div style="display:flex; justify-content:flex-end; margin-top:20px; padding-top:16px; border-top:1px solid var(--border);">
                        <button wire:click="updateProfile" wire:loading.attr="disabled" class="tp__btn-primary">
                            <span wire:loading wire:target="updateProfile">Saving...</span>
                            <span wire:loading.remove wire:target="updateProfile">Save Changes</span>
                        </button>
                    </div>
                </div>

            @endif

            {{-- ── TAB: PASSWORD & SECURITY ── --}}
            @if($activeTab === 'password')

                @if(session('password_saved'))
                    <div style="display:flex; align-items:center; gap:10px; background:#f0fdf4; border:1px solid #bbf7d0; border-radius:10px; padding:12px 16px; margin-bottom:16px; color:#15803d; font-size:13px; font-weight:600;">
                        <x-lucide-check-circle class="w-4 h-4" style="flex-shrink:0;" />
                        {{ session('password_saved') }}
                    </div>
                @endif

                <div class="card card-pad">
                    <div style="display:flex; align-items:center; gap:8px; margin-bottom:20px;">
                        <x-lucide-lock style="width:18px; height:18px; color:var(--primary); flex-shrink:0;" />
                        <h2 style="font-size:15px; font-weight:800; color:var(--text); margin:0;">Password & Security</h2>
                    </div>

                    <div style="display:flex; flex-direction:column; gap:16px; max-width:460px;">
                        <div x-data="{ show: false }">
                            <label class="tp__label">Current Password</label>
                            <div style="position:relative;">
                                <input :type="show ? 'text' : 'password'" wire:model="current_password" class="tp__input" placeholder="Enter current password" style="padding-right:42px;">
                                <button type="button" @click="show = !show" style="position:absolute; right:12px; top:50%; transform:translateY(-50%); background:none; border:none; cursor:pointer; color:var(--muted); display:flex; align-items:center;">
                                    <x-lucide-eye     x-show="!show" style="width:16px; height:16px;" />
                                    <x-lucide-eye-off x-show="show"  style="width:16px; height:16px;" />
                                </button>
                            </div>
                            @error('current_password') <span class="tp__error">⚠ {{ $message }}</span> @enderror
                        </div>

                        <div x-data="{ show: false }">
                            <label class="tp__label">New Password</label>
                            <div style="position:relative;">
                                <input :type="show ? 'text' : 'password'" wire:model="new_password" class="tp__input" placeholder="Enter new password" style="padding-right:42px;">
                                <button type="button" @click="show = !show" style="position:absolute; right:12px; top:50%; transform:translateY(-50%); background:none; border:none; cursor:pointer; color:var(--muted); display:flex; align-items:center;">
                                    <x-lucide-eye     x-show="!show" style="width:16px; height:16px;" />
                                    <x-lucide-eye-off x-show="show"  style="width:16px; height:16px;" />
                                </button>
                            </div>
                            <p style="font-size:11px; color:var(--muted); margin-top:5px; margin-bottom:0;">Minimum 8 characters with letters and numbers</p>
                            @error('new_password') <span class="tp__error">⚠ {{ $message }}</span> @enderror
                        </div>

                        <div x-data="{ show: false }">
                            <label class="tp__label">Confirm New Password</label>
                            <div style="position:relative;">
                                <input :type="show ? 'text' : 'password'" wire:model="new_password_confirmation" class="tp__input" placeholder="Repeat new password" style="padding-right:42px;">
                                <button type="button" @click="show = !show" style="position:absolute; right:12px; top:50%; transform:translateY(-50%); background:none; border:none; cursor:pointer; color:var(--muted); display:flex; align-items:center;">
                                    <x-lucide-eye     x-show="!show" style="width:16px; height:16px;" />
                                    <x-lucide-eye-off x-show="show"  style="width:16px; height:16px;" />
                                </button>
                            </div>
                            @error('new_password_confirmation') <span class="tp__error">⚠ {{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div style="display:flex; justify-content:flex-end; margin-top:20px; padding-top:16px; border-top:1px solid var(--border);">
                        <button wire:click="updatePassword" wire:loading.attr="disabled" class="tp__btn-primary">
                            <span wire:loading wire:target="updatePassword">Updating...</span>
                            <span wire:loading.remove wire:target="updatePassword">Update Password</span>
                        </button>
                    </div>
                </div>

            @endif

            {{-- ── TAB: TRANSACTION HISTORY ── --}}
            @if($activeTab === 'transactions')
                @php
                $transactions = [
                    ['date' => '15 Jan 2025', 'item' => 'TOEIC Speaking & Writing',  'type' => 'Enrollment', 'status' => 'Active',    'amount' => 'Free'],
                    ['date' => '10 Jan 2025', 'item' => 'TOEIC Listening & Reading', 'type' => 'Enrollment', 'status' => 'Completed', 'amount' => 'Free'],
                ];
                @endphp
                <div class="card">
                    <div style="padding:18px 22px; border-bottom:1px solid var(--border); display:flex; align-items:center; gap:8px;">
                        <x-lucide-receipt style="width:18px; height:18px; color:var(--primary); flex-shrink:0;" />
                        <div>
                            <h2 style="font-size:15px; font-weight:800; color:var(--text); margin:0;">Transaction History</h2>
                            <p style="font-size:12px; color:var(--muted); margin:2px 0 0 0;">Your exam enrollment history</p>
                        </div>
                    </div>
                    <div style="overflow-x:auto;">
                        <table style="width:100%; border-collapse:collapse;">
                            <thead>
                                <tr style="background:var(--base);">
                                    @foreach(['Date','Item','Type','Status','Amount'] as $col)
                                        <th style="padding:10px 16px; text-align:left; font-size:11px; font-weight:800; color:var(--muted); text-transform:uppercase; letter-spacing:0.06em; white-space:nowrap;">{{ $col }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transactions as $tx)
                                <tr style="border-bottom:1px solid var(--border);" onmouseover="this.style.background='var(--base)'" onmouseout="this.style.background='transparent'">
                                    <td style="padding:13px 16px; font-size:13px; color:var(--muted); white-space:nowrap;">{{ $tx['date'] }}</td>
                                    <td style="padding:13px 16px; font-size:13px; color:var(--text); font-weight:600;">{{ $tx['item'] }}</td>
                                    <td style="padding:13px 16px; font-size:13px; color:var(--muted);">{{ $tx['type'] }}</td>
                                    <td style="padding:13px 16px;">
                                        @php
                                        $badge = match($tx['status']) {
                                            'Active'    => 'background:#dcfce7; color:#15803d; border:1px solid #bbf7d0;',
                                            'Completed' => 'background:#f1f5f9; color:#64748b; border:1px solid #e2e8f0;',
                                            'Pending'   => 'background:#fef9c3; color:#a16207; border:1px solid #fde68a;',
                                            default     => 'background:#f1f5f9; color:#64748b; border:1px solid #e2e8f0;',
                                        };
                                        @endphp
                                        <span style="font-size:11px; font-weight:700; padding:3px 10px; border-radius:99px; {{ $badge }}">{{ $tx['status'] }}</span>
                                    </td>
                                    <td style="padding:13px 16px; font-size:13px; font-weight:700; color:var(--text);">{{ $tx['amount'] }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" style="text-align:center; padding:40px 20px; color:var(--muted);">
                                        <x-lucide-receipt style="width:32px; height:32px; opacity:0.3; display:block; margin:0 auto 10px;" />
                                        <p style="font-size:14px; font-weight:600; margin:0 0 4px 0;">No transactions yet</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            {{-- ── TAB: CERTIFICATES ── --}}
            @if($activeTab === 'certificates')
                @php
                $certificates = [
                    ['title' => 'TOEIC Speaking & Writing',  'score' => '750 / 990', 'date' => 'Feb 2025',    'level' => 'Proficiency', 'badge_bg' => '#dbeafe', 'badge_color' => '#1d4ed8'],
                    ['title' => 'TOEIC Listening & Reading', 'score' => '—',         'date' => 'In Progress', 'level' => 'Pending',     'badge_bg' => '#f1f5f9', 'badge_color' => '#64748b'],
                ];
                @endphp
                <div class="card card-pad">
                    <div style="display:flex; align-items:center; gap:8px; margin-bottom:20px;">
                        <x-lucide-award style="width:18px; height:18px; color:var(--primary); flex-shrink:0;" />
                        <h2 style="font-size:15px; font-weight:800; color:var(--text); margin:0;">My Certificates</h2>
                    </div>
                    <div style="display:grid; grid-template-columns:repeat(auto-fill,minmax(200px,1fr)); gap:16px;">
                        @foreach($certificates as $cert)
                        <div style="border:1px solid var(--border); border-radius:14px; padding:18px;">
                            <div style="display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:12px;">
                                <x-lucide-medal style="width:28px; height:28px; color:var(--primary);" />
                                <span style="font-size:11px; font-weight:700; padding:3px 10px; border-radius:99px; background:{{ $cert['badge_bg'] }}; color:{{ $cert['badge_color'] }};">{{ $cert['level'] }}</span>
                            </div>
                            <div style="font-size:13px; font-weight:700; color:var(--text); margin-bottom:6px; line-height:1.3;">{{ $cert['title'] }}</div>
                            <div style="font-size:22px; font-weight:900; color:var(--primary); margin-bottom:2px;">{{ $cert['score'] }}</div>
                            <div style="font-size:12px; color:var(--muted); margin-bottom:14px;">{{ $cert['date'] }}</div>
                            @if($cert['score'] !== '—')
                            <button class="tp__btn-outline" style="width:100%; justify-content:center; display:flex; align-items:center; gap:6px;">
                                <x-lucide-download style="width:14px; height:14px;" /> Download PDF
                            </button>
                            @else
                            <button disabled class="tp__btn-outline" style="width:100%; justify-content:center; display:flex; align-items:center; gap:6px; opacity:0.45; cursor:not-allowed;">
                                <x-lucide-clock style="width:14px; height:14px;" /> In Progress
                            </button>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- ── TAB: DELETE ACCOUNT ── --}}
            @if($activeTab === 'delete')
                <div class="card card-pad" style="border-color:#fca5a5;">
                    <div style="display:flex; align-items:center; gap:8px; margin-bottom:14px;">
                        <x-lucide-trash-2 style="width:18px; height:18px; color:#ef4444; flex-shrink:0;" />
                        <h2 style="font-size:15px; font-weight:800; color:#ef4444; margin:0;">Delete Account</h2>
                    </div>
                    <p style="font-size:13px; color:var(--muted); margin:0 0 16px 0; line-height:1.6; max-width:480px;">
                        Once your account is deleted, all of its resources and data will be permanently deleted.
                        Before deleting your account, please download any data or information that you wish to retain.
                    </p>
                    <button
                        onclick="this.closest('div').querySelector('[data-confirm]').classList.toggle('hidden')"
                        style="display:inline-flex; align-items:center; gap:6px; font-size:13px; font-weight:700; padding:10px 18px; border-radius:9px; background:#fef2f2; color:#ef4444; border:1.5px solid #fca5a5; cursor:pointer;">
                        <x-lucide-trash-2 style="width:14px; height:14px;" /> Delete My Account
                    </button>
                    <div data-confirm class="hidden" style="margin-top:16px; padding:16px; border-radius:12px; background:#fef2f2; border:1.5px solid #fca5a5;">
                        <p style="font-size:13px; font-weight:600; color:#991b1b; margin:0 0 12px 0;">Are you sure? This action cannot be undone.</p>
                        <div style="display:flex; gap:10px; align-items:center;">
                            <input type="password" wire:model="current_password" placeholder="Enter your password to confirm"
                                style="flex:1; font-size:13px; padding:9px 13px; border:1.5px solid #fca5a5; border-radius:9px; outline:none; background:white; color:#0D1B2A; font-family:inherit;">
                            <button wire:click="deleteAccount" wire:loading.attr="disabled"
                                style="font-size:13px; font-weight:700; padding:9px 18px; border-radius:9px; background:#ef4444; color:white; border:none; cursor:pointer; white-space:nowrap;">
                                <span wire:loading wire:target="deleteAccount">Deleting...</span>
                                <span wire:loading.remove wire:target="deleteAccount">Yes, Delete</span>
                            </button>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>

    {{-- ══════════════════════════════════════
         PHOTO PICKER MODAL
    ══════════════════════════════════════ --}}
    @if($showPhotoPicker)
    <div
        style="position:fixed; inset:0; background:rgba(15,23,42,0.4); backdrop-filter:blur(4px); z-index:9999; display:flex; align-items:center; justify-content:center; padding:20px;"
        wire:click.self="closePhotoPicker"
    >
        <div style="background:white; border-radius:20px; width:90%; max-width:460px; box-shadow:0 20px 60px rgba(0,0,0,0.15); overflow:hidden;">

            <div style="display:flex; align-items:center; justify-content:space-between; padding:18px 22px; border-bottom:1px solid var(--border);">
                <div style="display:flex; align-items:center; gap:8px;">
                    <x-lucide-image style="width:18px; height:18px; color:var(--primary);" />
                    <span style="font-size:15px; font-weight:800; color:var(--text);">Choose Profile Photo</span>
                </div>
                <button wire:click="closePhotoPicker" style="background:none; border:none; cursor:pointer; color:var(--muted); display:flex; padding:4px;">
                    <x-lucide-x style="width:20px; height:20px;" />
                </button>
            </div>

            <div style="padding:14px 22px 0; display:flex; gap:8px;">
                <button wire:click="$set('photoPickerTab', 'upload')"
                    style="font-size:13px; font-weight:700; padding:7px 16px; border-radius:99px; border:none; cursor:pointer; transition:all 0.2s; {{ $photoPickerTab === 'upload' ? 'background:var(--primary); color:white;' : 'background:var(--base); color:var(--muted);' }}"
                >Upload Photo</button>
                <button wire:click="$set('photoPickerTab', 'preset')"
                    style="font-size:13px; font-weight:700; padding:7px 16px; border-radius:99px; border:none; cursor:pointer; transition:all 0.2s; {{ $photoPickerTab === 'preset' ? 'background:var(--primary); color:white;' : 'background:var(--base); color:var(--muted);' }}"
                >Choose Preset</button>
            </div>

            <div style="padding:18px 22px;">
                @if($photoPickerTab === 'upload')
                    <label style="display:block; border:2px dashed var(--border); border-radius:14px; padding:28px 20px; text-align:center; background:var(--base); cursor:pointer; transition:all 0.2s;"
                        onmouseover="this.style.borderColor='var(--primary)'"
                        onmouseout="this.style.borderColor='var(--border)'"
                    >
                        @if($photoUpload)
                            <div style="display:flex; flex-direction:column; align-items:center; gap:10px;">
                                <img src="{{ $photoUpload->temporaryUrl() }}" style="width:72px; height:72px; border-radius:50%; object-fit:cover; border:2px solid var(--secondary);">
                                <span style="font-size:13px; color:var(--text); font-weight:600;">{{ $photoUpload->getClientOriginalName() }}</span>
                                <span style="font-size:12px; color:var(--muted);">Click to change</span>
                            </div>
                        @else
                            <x-lucide-upload-cloud style="width:28px; height:28px; color:var(--muted); display:block; margin:0 auto 8px;" />
                            <p style="font-size:13px; color:var(--muted); margin:0 0 4px 0; font-weight:500;">Click to upload or drag & drop</p>
                            <p style="font-size:11px; color:var(--muted); margin:0;">PNG, JPG, GIF up to 2MB</p>
                        @endif
                        <input type="file" wire:model="photoUpload" accept="image/*" style="display:none;">
                    </label>
                    @error('photoUpload') <span class="tp__error" style="margin-top:8px; display:block;">⚠ {{ $message }}</span> @enderror
                @else
                    <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:12px;">
                        @foreach($presetAvatars as $preset)
                        @php $label = 'Avatar ' . (array_search($preset, $presetAvatars) + 1); @endphp
                        <button
                            wire:click="selectPreset('{{ $preset }}')"
                            style="padding:6px; border-radius:12px; border:3px solid {{ $selectedPreset === $preset ? 'var(--primary)' : 'transparent' }}; background:none; cursor:pointer; transition:all 0.2s; box-shadow:{{ $selectedPreset === $preset ? '0 0 0 4px rgba(26,69,108,0.12)' : 'none' }};"
                        >
                            <img
                                src="{{ asset('assets/avatars/presets/' . basename($preset)) }}"
                                alt="{{ $label }}"
                                style="width:72px; height:72px; border-radius:50%; object-fit:cover; display:block; margin:0 auto; background:var(--base);"
                                onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                            >
                            <div style="display:none; width:72px; height:72px; border-radius:50%; background:linear-gradient(135deg,var(--primary),var(--secondary)); color:white; font-weight:800; font-size:18px; align-items:center; justify-content:center; margin:0 auto;">
                                {{ $label[strlen($label)-1] }}
                            </div>
                        </button>
                        @endforeach
                    </div>
                @endif
            </div>

            <div style="padding:14px 22px; border-top:1px solid var(--border); display:flex; justify-content:flex-end; gap:10px;">
                <button wire:click="closePhotoPicker" class="tp__btn-outline">Cancel</button>
                <button
                    wire:click="applyPhoto"
                    wire:loading.attr="disabled"
                    class="tp__btn-primary"
                    style="{{ (!$photoUpload && !$selectedPreset) ? 'opacity:0.45; cursor:not-allowed;' : '' }}"
                >
                    <span wire:loading wire:target="applyPhoto">Applying...</span>
                    <span wire:loading.remove wire:target="applyPhoto">Apply Photo</span>
                </button>
            </div>
        </div>
    </div>
    @endif

</div>
