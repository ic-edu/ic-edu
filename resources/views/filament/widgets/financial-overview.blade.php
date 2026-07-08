<x-filament-widgets::widget>
    <style>
        .fin-ov-card {
            background: #ffffff;
            border: 1px solid rgba(0, 0, 0, 0.05);
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }
        .dark .fin-ov-card {
            background: #0f172a;
            border-color: rgba(255, 255, 255, 0.05);
        }
        .fin-ov-header {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: flex-start;
            gap: 1rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            padding-bottom: 1.5rem;
            margin-bottom: 1.5rem;
        }
        @media (min-width: 768px) {
            .fin-ov-header {
                flex-direction: row;
                align-items: center;
            }
        }
        .fin-ov-grand-total {
            display: flex;
            align-items: center;
            gap: 1rem;
            background: linear-gradient(135deg, #3b82f6 0%, #4f46e5 100%);
            color: #ffffff;
            padding: 0.75rem 1.25rem;
            border-radius: 0.75rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        .fin-ov-grand-total svg {
            width: 1.5rem;
            height: 1.5rem;
            flex-shrink: 0;
        }
        .fin-ov-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }
        @media (min-width: 1024px) {
            .fin-ov-grid {
                grid-template-columns: 1fr 1fr;
            }
        }
        .fin-ov-col-card {
            background: #f8fafc;
            border: 1px solid rgba(0, 0, 0, 0.05);
            border-radius: 0.75rem;
            padding: 1.25rem;
        }
        .dark .fin-ov-col-card {
            background: rgba(255, 255, 255, 0.02);
            border-color: rgba(255, 255, 255, 0.05);
        }
        .fin-ov-col-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }
        .fin-ov-col-title {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        .fin-ov-col-icon {
            padding: 0.5rem;
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .fin-ov-col-icon svg {
            width: 1.25rem;
            height: 1.25rem;
        }
        .fin-ov-icon-emerald {
            background: rgba(16, 185, 129, 0.1);
            color: #10b981;
        }
        .fin-ov-icon-blue {
            background: rgba(59, 130, 246, 0.1);
            color: #3b82f6;
        }
        .fin-ov-badge-emerald {
            background: rgba(16, 185, 129, 0.1);
            color: #047857;
            padding: 0.25rem 0.5rem;
            border-radius: 0.375rem;
            font-size: 0.75rem;
            font-weight: 600;
        }
        .dark .fin-ov-badge-emerald {
            color: #34d399;
        }
        .fin-ov-badge-blue {
            background: rgba(59, 130, 246, 0.1);
            color: #1d4ed8;
            padding: 0.25rem 0.5rem;
            border-radius: 0.375rem;
            font-size: 0.75rem;
            font-weight: 600;
        }
        .dark .fin-ov-badge-blue {
            color: #60a5fa;
        }
        .fin-ov-stats-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        .fin-ov-stat-box {
            background: #ffffff;
            padding: 1rem;
            border-radius: 0.5rem;
            border: 1px solid rgba(0, 0, 0, 0.03);
        }
        .dark .fin-ov-stat-box {
            background: rgba(15, 23, 42, 0.5);
            border-color: rgba(255, 255, 255, 0.03);
        }
        .fin-ov-stat-label {
            font-size: 0.75rem;
            color: #94a3b8;
            display: block;
        }
        .fin-ov-stat-val {
            font-size: 1.25rem;
            font-weight: 800;
            margin-top: 0.25rem;
            display: block;
        }
        .fin-ov-recent-title {
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #94a3b8;
            margin-bottom: 0.75rem;
        }
        .fin-ov-list {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }
        .fin-ov-list-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.625rem;
            background: #ffffff;
            border: 1px solid rgba(0, 0, 0, 0.03);
            border-radius: 0.5rem;
            transition: background 0.15s ease;
        }
        .dark .fin-ov-list-item {
            background: rgba(15, 23, 42, 0.4);
            border-color: rgba(255, 255, 255, 0.03);
        }
        .fin-ov-list-item:hover {
            background: #f1f5f9;
        }
        .dark .fin-ov-list-item:hover {
            background: rgba(255, 255, 255, 0.05);
        }
        .fin-ov-avatar {
            width: 2rem;
            height: 2rem;
            border-radius: 9999px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 0.75rem;
            text-transform: uppercase;
        }
        .fin-ov-footer-stats {
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
            display: grid;
            grid-template-columns: 1fr;
            gap: 1.5rem;
            background: rgba(241, 245, 249, 0.5);
            padding: 1.25rem;
            border-radius: 0.75rem;
        }
        .dark .fin-ov-footer-stats {
            background: rgba(255, 255, 255, 0.01);
            border-color: rgba(255, 255, 255, 0.05);
        }
        @media (min-width: 768px) {
            .fin-ov-footer-stats {
                grid-template-columns: 1fr 1fr 1fr;
            }
        }
        .fin-ov-footer-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        .fin-ov-footer-icon {
            padding: 0.5rem;
            background: rgba(79, 70, 229, 0.1);
            color: #4f46e5;
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .fin-ov-footer-icon svg {
            width: 1.25rem;
            height: 1.25rem;
        }
    </style>

    <div class="fin-ov-card">
        
        <!-- Header Section -->
        <div class="fin-ov-header">
            <div>
                <h2 style="font-size: 1.25rem; font-weight: 700; color: inherit;">
                    Financial & Revenue Breakdown
                </h2>
                <p style="font-size: 0.875rem; color: #94a3b8; margin-top: 0.25rem;">
                    Detailed transaction analysis across course enrollments and token sales.
                </p>
            </div>
        </div>

        <!-- Two Columns: Courses vs Tokens -->
        <div class="fin-ov-grid">
            
            <!-- Column 1: Course Purchases -->
            <div class="fin-ov-col-card">
                <div class="fin-ov-col-header">
                    <div class="fin-ov-col-title">
                        <div class="fin-ov-col-icon fin-ov-icon-emerald">
                            <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.57 50.57 0 0 0-2.658-.813A5.906 5.906 0 0 1 12 3.406a5.906 5.906 0 0 1 8.36 5.928 50.581 50.581 0 0 0-2.658.813M4.17 11.5a48.366 48.366 0 0 0-1.093-1.03M20.276 11.5c.34-.339.707-.655 1.093-1.03M1.5 9.5 12 15l10.5-5.5M12 11.25v8.25" />
                            </svg>
                        </div>
                        <div>
                            <h3 style="font-weight: 700; color: inherit; font-size: 0.95rem;">Course Purchases</h3>
                            <p style="font-size: 0.75rem; color: #94a3b8; margin: 0;">Student enrollment billing</p>
                        </div>
                    </div>
                    <span class="fin-ov-badge-emerald">Course Revenue</span>
                </div>
                
                <div class="fin-ov-stats-grid">
                    <div class="fin-ov-stat-box">
                        <span class="fin-ov-stat-label">Total Enrolled</span>
                        <span class="fin-ov-stat-val text-gray-800 dark:text-gray-200">
                            {{ $courseCount }} <span style="font-size: 0.75rem; font-weight: 400; color: #94a3b8;">purchases</span>
                        </span>
                    </div>
                    <div class="fin-ov-stat-box">
                        <span class="fin-ov-stat-label">Course Income</span>
                        <span class="fin-ov-stat-val text-emerald-600 dark:text-emerald-400">
                            Rp {{ number_format($courseRevenue, 0, ',', '.') }}
                        </span>
                    </div>
                </div>

                <div>
                    <h4 class="fin-ov-recent-title">Recent Enrollments</h4>
                    <div class="fin-ov-list">
                        @forelse($recentEnrollments as $enrollment)
                            <div class="fin-ov-list-item">
                                <div style="display: flex; align-items: center; gap: 0.75rem;">
                                    <div class="fin-ov-avatar" style="background: rgba(16, 185, 129, 0.1); color: #10b981;">
                                        {{ substr($enrollment->user->name ?? 'U', 0, 2) }}
                                    </div>
                                    <div>
                                        <p style="font-size: 0.75rem; font-weight: 600; margin: 0; color: inherit;">{{ $enrollment->user->name ?? 'Unknown Student' }}</p>
                                        <p style="font-size: 0.65rem; color: #94a3b8; margin: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 150px;" title="{{ $enrollment->course->title ?? 'Untitled Course' }}">
                                            {{ $enrollment->course->title ?? 'Untitled Course' }}
                                        </p>
                                    </div>
                                </div>
                                <div style="text-align: right;">
                                    <span style="font-size: 0.75rem; font-weight: 700; color: inherit;">
                                        <svg style="width:12px;height:12px;color:#0ea5e9;vertical-align:middle;margin-right:2px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        {{ $enrollment->course->tokens_required ?? 0 }} Tokens
                                    </span>
                                    <span style="font-size: 0.6rem; color: #94a3b8; display: block; margin-top: 0.125rem;">
                                        {{ $enrollment->enrolled_at ? $enrollment->enrolled_at->diffForHumans() : '-' }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <p style="font-size: 0.75rem; color: #94a3b8; text-align: center; padding: 1rem 0; margin: 0;">No course enrollments yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>
            
            <!-- Column 2: Token Top-Ups -->
            <div class="fin-ov-col-card">
                <div class="fin-ov-col-header">
                    <div class="fin-ov-col-title">
                        <div class="fin-ov-col-icon fin-ov-icon-blue">
                            <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.752.315A5.002 5.002 0 0 0 16.5 13.565V12.18a5.002 5.002 0 0 0-6.748-4.743L9 7.75" />
                            </svg>
                        </div>
                        <div>
                            <h3 style="font-weight: 700; color: inherit; font-size: 0.95rem;">Token Sales</h3>
                            <p style="font-size: 0.75rem; color: #94a3b8; margin: 0;">Wallet balance purchases</p>
                        </div>
                    </div>
                    <span class="fin-ov-badge-blue">Token Revenue</span>
                </div>
                
                <div class="fin-ov-stats-grid">
                    <div class="fin-ov-stat-box">
                        <span class="fin-ov-stat-label">Tokens Top Up</span>
                        <span class="fin-ov-stat-val text-gray-800 dark:text-gray-200">
                            {{ $tokensPurchased }} <span style="font-size: 0.75rem; font-weight: 400; color: #94a3b8;">units</span>
                        </span>
                    </div>
                    <div class="fin-ov-stat-box">
                        <span class="fin-ov-stat-label">Token Income</span>
                        <span class="fin-ov-stat-val text-blue-600 dark:text-blue-400">
                            Rp {{ number_format($tokenRevenue, 0, ',', '.') }}
                        </span>
                    </div>
                </div>

                <div>
                    <h4 class="fin-ov-recent-title">Recent Token Purchases</h4>
                    <div class="fin-ov-list">
                        @forelse($recentTransactions as $tx)
                            <div class="fin-ov-list-item">
                                <div style="display: flex; align-items: center; gap: 0.75rem;">
                                    <div class="fin-ov-avatar" style="background: rgba(59, 130, 246, 0.1); color: #3b82f6;">
                                        +{{ $tx->amount }}
                                    </div>
                                    <div>
                                        <p style="font-size: 0.75rem; font-weight: 600; margin: 0; color: inherit;">{{ $tx->user->name ?? 'Unknown Student' }}</p>
                                        <p style="font-size: 0.65rem; color: #94a3b8; margin: 0; font-family: monospace;">{{ $tx->reference_id }}</p>
                                    </div>
                                </div>
                                <div style="text-align: right;">
                                    <span style="font-size: 0.75rem; font-weight: 700; color: inherit;">
                                        @php
                                            $qty = abs($tx->amount);
                                            $price = $qty * 99000;
                                            if ($qty === 1) $price = 99000;
                                            elseif ($qty === 3) $price = 249000;
                                            elseif ($qty === 5) $price = 399000;
                                        @endphp
                                        Rp {{ number_format($price, 0, ',', '.') }}
                                    </span>
                                    <span style="font-size: 0.6**rem; color: #94a3b8; display: block; margin-top: 0.125rem;">
                                        {{ $tx->created_at->diffForHumans() }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <p style="font-size: 0.75rem; color: #94a3b8; text-align: center; padding: 1rem 0; margin: 0;">No token purchases yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>

        <!-- Marketing & Voucher Impact Footer -->
        <div class="fin-ov-footer-stats">
            <div class="fin-ov-footer-item">
                <div class="fin-ov-footer-icon">
                    <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-3-15.25a5.625 5.625 0 0 1-5.625 5.625 5.625 5.625 0 0 1-5.625-5.625 5.625 5.625 0 0 1 5.625-5.625A5.625 5.625 0 0 1 13.5 2.75Zm0 12.5a5.625 5.625 0 0 1-5.625 5.625 5.625 5.625 0 0 1-5.625-5.625 5.625 5.625 0 0 1 5.625-5.625A5.625 5.625 0 0 1 13.5 15.25Z" />
                    </svg>
                </div>
                <div>
                    <span style="font-size: 0.6rem; text-transform: uppercase; font-weight: 700; color: #94a3b8; display: block;">Total Vouchers Claimed</span>
                    <span style="font-size: 1rem; font-weight: 800; color: inherit; display: block; margin-top: 0.125rem;">
                        {{ $voucherCount }} <span style="font-size: 0.75rem; font-weight: 400; color: #94a3b8;">claims</span>
                    </span>
                </div>
            </div>
            
            <div class="fin-ov-footer-item">
                <div class="fin-ov-footer-icon">
                    <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
                    </svg>
                </div>
                <div>
                    <span style="font-size: 0.6rem; text-transform: uppercase; font-weight: 700; color: #94a3b8; display: block;">Promo Tokens Redeemed</span>
                    <span style="font-size: 1rem; font-weight: 800; color: inherit; display: block; margin-top: 0.125rem;">
                        {{ $tokensRedeemed }} <span style="font-size: 0.75rem; font-weight: 400; color: #94a3b8;">Tokens</span>
                    </span>
                </div>
            </div>
            
            <div class="fin-ov-footer-item">
                <div class="fin-ov-footer-icon" style="background: rgba(79, 70, 229, 0.1); color: #4f46e5;">
                    <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 0 1-2.25 2.25M16.5 7.5V18a2.25 2.25 0 0 0 2.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 0 0 2.25 2.25h13.5M6 7.5h3v3H6v-3Z" />
                    </svg>
                </div>
                <div>
                    <span style="font-size: 0.6rem; text-transform: uppercase; font-weight: 700; color: #94a3b8; display: block;">Promo Value Redeemed</span>
                    <span style="font-size: 1rem; font-weight: 800; color: #4f46e5; display: block; margin-top: 0.125rem;" title="Equivalent purchase value at Rp 99.000 per token">
                        Rp {{ number_format($equivalentPromoValue, 0, ',', '.') }}
                    </span>
                </div>
            </div>
        </div>

    </div>
</x-filament-widgets::widget>
