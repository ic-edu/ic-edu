@extends('layouts.test_taker')
@section('title', 'Wallet')

@push('styles')
<style>
    /* Premium Wallet Styles */
    .wallet-grid {
        display: grid;
        grid-template-columns: 1fr 1.5fr;
        gap: 2rem;
        margin-bottom: 2.5rem;
    }

    @media (max-width: 992px) {
        .wallet-grid {
            grid-template-columns: 1fr;
            gap: 1.5rem;
            align-items: stretch;
        }
    }

    /* Balance Card Styling */
    .wallet-card-navy {
        background: linear-gradient(135deg, #1A456C 0%, #112d47 100%);
        border-radius: 24px;
        padding: 2.25rem;
        color: #ffffff !important;
        position: relative;
        overflow: hidden;
        box-shadow: 0 12px 30px rgba(26, 69, 108, 0.15);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        min-height: 260px;
    }

    .wallet-card-navy::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        background-image: radial-gradient(circle at 80% 20%, rgba(111, 175, 181, 0.15) 0%, transparent 50%);
        pointer-events: none;
    }

    .wallet-coins-icon {
        position: absolute;
        bottom: -20px;
        right: -10px;
        font-size: 9rem;
        opacity: 0.08;
        color: #ffffff;
        pointer-events: none;
    }

    .wallet-card-navy h2.wallet-title-white {
        color: #ffffff !important;
        font-weight: 700;
        font-size: 1.5rem;
    }

    .wallet-card-navy .balance-gold-label {
        font-size: 3.5rem;
        font-weight: 900;
        color: #E6AF2E;
        line-height: 1;
        font-family: 'Poppins', sans-serif;
    }

    /* Top-Up Card Styling */
    .wallet-card-topup {
        background: #ffffff;
        border: 1px solid var(--border);
        border-radius: 24px;
        padding: 2.25rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.02);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        min-height: 260px;
        position: relative;
        transition: border-color 0.3s ease;
    }

    .wallet-card-topup:hover {
        border-color: rgba(111, 175, 181, 0.4);
    }

    /* Quantity Control */
    .qty-selector {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        background: #F8F9FA;
        border: 1px solid var(--border);
        border-radius: 14px;
        padding: 4px;
        width: fit-content;
    }

    .qty-btn {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        border: none;
        background: #ffffff;
        color: #1A456C;
        font-weight: 700;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }

    .qty-btn:hover:not(:disabled) {
        background: #1A456C;
        color: #ffffff;
    }

    .qty-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .qty-input {
        width: 50px;
        border: none;
        background: transparent;
        text-align: center;
        font-weight: 800;
        font-size: 1.1rem;
        color: #1A456C;
        padding: 0;
        focus: outline-none;
    }

    .qty-input::-webkit-outer-spin-button,
    .qty-input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Price tag and summary */
    .price-value-large {
        font-size: 1.75rem;
        font-weight: 800;
        color: #1A456C;
        font-family: 'Poppins', sans-serif;
    }

    /* History layout */
    .tx-section {
        background: #ffffff;
        border: 1px solid var(--border);
        border-radius: 24px;
        padding: 2.25rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.01);
        margin-bottom: 2rem;
    }

    .tx-header-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.75rem;
    }

    .table-container {
        overflow-x: auto;
    }

    .tx-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }

    .tx-table th {
        padding: 1.15rem 1.25rem;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        color: var(--muted);
        border-bottom: 1px solid var(--border);
        letter-spacing: 0.05em;
    }

    .tx-table td {
        padding: 1.15rem 1.25rem;
        font-size: 0.85rem;
        color: var(--text);
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .tx-table tr:last-child td {
        border-bottom: none;
    }

    .badge-status {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 4px 10px;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .badge-status.success {
        background: #E6F4EA;
        color: #137333;
    }

    .badge-status.deducted {
        background: #F1F5F9;
        color: #475569;
    }

    .tx-amount {
        font-weight: 700;
        font-family: 'Poppins', sans-serif;
    }

    .tx-amount.plus {
        color: #137333;
    }

    .tx-amount.minus {
        color: var(--text);
    }

    /* Custom Pagination Styling */
    .paginator-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 1.5rem;
        padding-top: 1.25rem;
        border-t: 1px solid #f1f5f9;
    }

    .paginator-btn {
        padding: 0.5rem 1rem;
        border-radius: 10px;
        border: 1px solid var(--border);
        background: #ffffff;
        color: #1A456C;
        font-size: 0.8rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .paginator-btn:hover:not(:disabled) {
        background: #F8F9FA;
        border-color: #cbd5e1;
    }

    .paginator-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
</style>
@endpush

@section('content')
<div class="px-2 py-4">

    {{-- BREADCRUMBS --}}
    <div class="ec__breadcrumb mb-6">
        <span class="ec__breadcrumb-root">Portal</span>
        <svg width="12" height="12" viewBox="0 0 12 12" fill="none">
            <path d="M4.5 3L7.5 6L4.5 9" stroke="#94a3b8" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        <span class="ec__breadcrumb-current">Wallet</span>
    </div>

    {{-- TOP GRID: BALANCE & TOPUP --}}
    <div class="wallet-grid">
        
        {{-- Left Column: Balance & Voucher --}}
        <div class="flex flex-col gap-6 h-full">
            {{-- Navy Balance Card --}}
            <div class="wallet-card-navy">
                <div class="wallet-coins-icon">
                    <x-lucide-coins />
                </div>

                <div class="flex justify-between items-start">
                    <div>
                        <span class="text-xs uppercase font-extrabold tracking-wider text-blue-200/80 block mb-1">Universal Wallet</span>
                        <h2 class="wallet-title-white">Your Tokens</h2>
                    </div>
                    <div class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-pulse" title="Wallet Connected"></div>
                </div>

                <div class="my-6">
                    <span class="text-xs text-blue-200/70 block mb-1">Available Balance</span>
                    <div class="flex items-baseline gap-2">
                        <span class="balance-gold-label">{{ auth()->user()->tokens ?? 0 }}</span>
                        <span class="text-sm font-bold text-blue-100">Universal Token{{ (auth()->user()->tokens ?? 0) != 1 ? 's' : '' }}</span>
                    </div>
                </div>

                <div class="pt-4 border-t border-white/10 flex justify-between items-center text-[0.725rem] text-blue-200/60 font-medium">
                    <span>Account: {{ auth()->user()->email }}</span>
                </div>
            </div>

            {{-- Voucher Redemption Card --}}
            <div class="bg-white rounded-2xl border border-slate-200/60 p-6 shadow-sm flex flex-col justify-center gap-4 relative overflow-hidden group hover:border-brand-primary/30 transition-colors flex-1">
                <div class="absolute -right-4 -top-4 text-slate-50 opacity-50 group-hover:scale-110 transition-transform duration-500">
                    <x-lucide-ticket class="w-32 h-32" />
                </div>
                
                <div class="relative z-10">
                    <div class="flex items-center gap-2 mb-1">
                        <x-lucide-ticket class="w-4 h-4 text-brand-primary" />
                        <h3 class="font-bold text-slate-800 text-sm uppercase tracking-wide">Redeem Voucher</h3>
                    </div>
                    <p class="text-xs text-slate-500 mb-4">Have a token code or coupon? Enter it here to claim your tokens.</p>
                    
                    <div class="flex gap-2">
                        <input type="text" id="voucherCode" placeholder="e.g. TOEFL-PROMO-2026" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-700 focus:outline-none focus:ring-2 focus:ring-brand-primary/20 focus:border-brand-primary uppercase placeholder:normal-case transition-all">
                        <button type="button" onclick="redeemVoucher()" class="px-5 py-2.5 bg-slate-800 hover:bg-slate-700 text-white text-sm font-bold rounded-xl transition shadow-sm whitespace-nowrap flex items-center gap-2">
                            <span>Claim</span>
                            <x-lucide-arrow-right class="w-4 h-4" />
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right: Package-based Top-up Card --}}
        <div class="wallet-card-topup">
            <div class="flex justify-between items-start mb-2">
                <div>
                    <span class="text-xs uppercase font-extrabold tracking-wider text-amber-600 block mb-0.5">Top Up Balance</span>
                    <h2 class="text-xl font-bold font-heading text-slate-800">Purchase Exam Tokens</h2>
                </div>
            </div>

            <p class="text-xs text-slate-500 leading-relaxed mb-4">
                Tokens are universal and can be used to unlock any IELTS, TOEIC, or TOEFL practice simulator.
            </p>

            {{-- Package Selection --}}
            <div class="space-y-2 mb-4" id="package-list">
                @php
                    $save3 = round((1 - $package3Price / ($tokenPrice * 3)) * 100);
                    $save5 = round((1 - $package5Price / ($tokenPrice * 5)) * 100);
                @endphp

                {{-- 1 Token Package --}}
                <label class="package-option flex items-center gap-3 p-3 rounded-2xl border-2 border-brand-primary bg-brand-primary/5 cursor-pointer transition-all hover:shadow-sm" data-qty="1" data-price="{{ $tokenPrice }}">
                    <input type="radio" name="token_package" value="1" checked class="accent-brand-primary" onchange="selectPackage(1, {{ $tokenPrice }})">
                    <div class="flex-grow">
                        <div class="text-sm font-bold text-slate-800">1 Token</div>
                        <div class="text-xs text-slate-400">Single exam session</div>
                    </div>
                    <div class="text-right shrink-0">
                        <div class="text-sm font-extrabold text-brand-primary">Rp {{ number_format($tokenPrice, 0, ',', '.') }}</div>
                    </div>
                </label>

                {{-- 3 Token Package --}}
                <label class="package-option flex items-center gap-3 p-3 rounded-2xl border-2 border-slate-200 cursor-pointer transition-all hover:shadow-sm hover:border-brand-primary/40" data-qty="3" data-price="{{ $package3Price }}">
                    <input type="radio" name="token_package" value="3" class="accent-brand-primary" onchange="selectPackage(3, {{ $package3Price }})">
                    <div class="flex-grow">
                        <div class="flex items-center gap-2">
                            <span class="text-sm font-bold text-slate-800">3 Tokens</span>
                            @if($save3 > 0)
                                <span class="text-[0.6rem] font-extrabold bg-emerald-100 text-emerald-700 px-1.5 py-0.5 rounded-full">Save {{ $save3 }}%</span>
                            @endif
                        </div>
                        <div class="text-xs text-slate-400">3 exam sessions</div>
                    </div>
                    <div class="text-right shrink-0">
                        <div class="text-sm font-extrabold text-brand-primary">Rp {{ number_format($package3Price, 0, ',', '.') }}</div>
                        <div class="text-[0.6rem] text-slate-400 line-through">Rp {{ number_format($tokenPrice * 3, 0, ',', '.') }}</div>
                    </div>
                </label>

                {{-- 5 Token Package --}}
                <label class="package-option flex items-center gap-3 p-3 rounded-2xl border-2 border-slate-200 cursor-pointer transition-all hover:shadow-sm hover:border-brand-primary/40" data-qty="5" data-price="{{ $package5Price }}">
                    <input type="radio" name="token_package" value="5" class="accent-brand-primary" onchange="selectPackage(5, {{ $package5Price }})">
                    <div class="flex-grow">
                        <div class="flex items-center gap-2">
                            <span class="text-sm font-bold text-slate-800">5 Tokens</span>
                            @if($save5 > 0)
                                <span class="text-[0.6rem] font-extrabold bg-amber-100 text-amber-700 px-1.5 py-0.5 rounded-full">Best Value — Save {{ $save5 }}%</span>
                            @endif
                        </div>
                        <div class="text-xs text-slate-400">5 exam sessions</div>
                    </div>
                    <div class="text-right shrink-0">
                        <div class="text-sm font-extrabold text-brand-primary">Rp {{ number_format($package5Price, 0, ',', '.') }}</div>
                        <div class="text-[0.6rem] text-slate-400 line-through">Rp {{ number_format($tokenPrice * 5, 0, ',', '.') }}</div>
                    </div>
                </label>
            </div>

            {{-- Selected Total --}}
            <div class="flex items-center justify-between px-3 py-2.5 bg-slate-50 rounded-xl border border-slate-100 mb-4">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wide">Total</span>
                <div class="price-value-large" id="total-price-display">Rp {{ number_format($tokenPrice, 0, ',', '.') }}</div>
            </div>

            <button type="button" onclick="checkoutSelectedTokens()" class="w-full py-3.5 bg-brand-primary hover:bg-brand-primary/95 text-white font-bold rounded-xl transition duration-200 shadow-md shadow-brand-primary/10 flex items-center justify-center gap-2 text-sm">
                <x-lucide-shopping-cart class="w-4 h-4" />
                <span>Buy Tokens</span>
            </button>
        </div>

    </div>

    {{-- BOTTOM SECTION: TRANSACTION HISTORY (FULL WIDTH) --}}
    <div class="tx-section w-full">
        <div class="tx-header-row">
            <div>
                <h3 class="text-lg font-bold font-heading text-slate-800">Transaction History</h3>
                <p class="text-xs text-slate-500 mt-0.5">Review your token purchases and exam deductions.</p>
            </div>
            <x-lucide-history class="w-5 h-5 text-slate-400" />
        </div>

        <div class="table-container">
            <table class="tx-table">
                <thead>
                    <tr>
                        <th>Description</th>
                        <th>Date</th>
                        <th>Ref ID</th>
                        <th>Amount</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody id="tx-table-body">
                    {{-- Dynamically populated by JS to handle premium pagination --}}
                </tbody>
            </table>
        </div>

        {{-- Pagination controls --}}
        <div class="paginator-container border-t border-slate-100">
            <span class="text-xs text-slate-400" id="paginator-info">Showing 1 to 5 of 8 activities</span>
            <div class="flex gap-2">
                <button type="button" id="btn-prev-page" onclick="prevPage()" class="paginator-btn">Previous</button>
                <button type="button" id="btn-next-page" onclick="nextPage()" class="paginator-btn">Next</button>
            </div>
        </div>
    </div>

</div>

{{-- Checkout Modal --}}
<div id="checkoutModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[200] hidden items-center justify-center transition-all duration-300">
    <div class="bg-white rounded-3xl max-w-md w-full mx-4 p-8 shadow-2xl border border-slate-100 transform scale-95 opacity-0 transition-all duration-300" id="checkoutModalContent">
        <div class="flex justify-between items-start mb-6">
            <h3 class="text-xl font-bold font-heading text-slate-800">Checkout Simulation</h3>
            <button onclick="closeCheckoutModal()" class="text-slate-400 hover:text-slate-600 transition">
                <x-lucide-x class="w-5 h-5" />
            </button>
        </div>

        <div class="mb-6 p-4 bg-slate-50 rounded-2xl border border-slate-100">
            <div class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Item Details</div>
            <div class="flex justify-between items-center">
                <span class="font-bold text-slate-800 text-sm"><span id="modalItemQty">1</span> Exam Token(s)</span>
                <span class="font-black text-brand-primary text-base" id="modalItemPrice">Rp {{ number_format($tokenPrice, 0, ',', '.') }}</span>
            </div>
        </div>

        {{-- Payment Methods Mock --}}
        <div class="mb-8">
            <div class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Select Payment Method</div>
            <div class="space-y-2">
                <label class="flex items-center gap-3 p-3 rounded-xl border border-brand-primary/20 bg-brand-primary/5 cursor-pointer hover:bg-slate-50 transition">
                    <input type="radio" name="payment_method" value="qris" checked class="text-brand-primary focus:ring-brand-primary">
                    <div class="flex-grow">
                        <div class="text-xs font-bold text-slate-800">QRIS (Instant Checkout)</div>
                        <div class="text-[0.65rem] text-slate-400">Pay using Gopay, OVO, Dana, LinkAja, ShopeePay, or Banking apps</div>
                    </div>
                </label>
                <label class="flex items-center gap-3 p-3 rounded-xl border border-slate-200 cursor-pointer hover:bg-slate-50 transition opacity-60">
                    <input type="radio" name="payment_method" value="va" disabled class="text-brand-primary focus:ring-brand-primary">
                    <div class="flex-grow">
                        <div class="text-xs font-bold text-slate-800">Virtual Account (Bank Transfer)</div>
                        <div class="text-[0.65rem] text-slate-400">Under maintenance</div>
                    </div>
                </label>
            </div>
        </div>

        <div class="flex gap-3">
            <button onclick="closeCheckoutModal()" class="flex-1 py-3 border border-slate-200 rounded-xl font-bold text-slate-500 hover:bg-slate-50 transition text-sm">
                Cancel
            </button>
            <button onclick="confirmPurchase()" id="btnConfirmPurchase" class="flex-1 py-3 bg-brand-primary hover:bg-brand-primary/95 text-white rounded-xl font-bold transition shadow-lg shadow-brand-primary/10 text-sm flex items-center justify-center gap-2">
                <x-lucide-check-circle class="w-4 h-4" />
                <span>Simulate Pay</span>
            </button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Package pricing from DB (set by admin in App Settings)
    const tokenPrice     = {{ $tokenPrice }};
    const package3Price  = {{ $package3Price }};
    const package5Price  = {{ $package5Price }};

    let selectedPackageQty   = 1;
    let selectedPackagePrice = tokenPrice;
    let displayPrice = document.getElementById('total-price-display');

    function selectPackage(qty, price) {
        selectedPackageQty   = qty;
        selectedPackagePrice = price;
        displayPrice.innerText = 'Rp ' + price.toLocaleString('id-ID');

        // Update highlight border on labels
        document.querySelectorAll('.package-option').forEach(el => {
            el.classList.remove('border-brand-primary', 'bg-brand-primary/5');
            el.classList.add('border-slate-200');
        });
        const selected = document.querySelector(`.package-option[data-qty="${qty}"]`);
        if (selected) {
            selected.classList.remove('border-slate-200');
            selected.classList.add('border-brand-primary', 'bg-brand-primary/5');
        }
    }

    // Legacy stubs kept for any remaining references
    function updatePrice() {}
    function incrementQty() {}
    function decrementQty() {}
    function validateQty() {}

    // Dynamic Transaction History from Database with Client-Side Pagination
    const mockTransactions = @json($mappedTransactions);

    const itemsPerPage = 5;
    let currentPage = 1;

    function renderTable() {
        const tbody = document.getElementById('tx-table-body');
        tbody.innerHTML = '';

        const start = (currentPage - 1) * itemsPerPage;
        const end = Math.min(start + itemsPerPage, mockTransactions.length);
        const paginatedItems = mockTransactions.slice(start, end);

        if (paginatedItems.length === 0) {
            tbody.innerHTML = `<tr><td colspan="5" class="text-center text-slate-400 py-6">No transaction history.</td></tr>`;
            return;
        }

        paginatedItems.forEach(item => {
            const isPlus = item.type === 'plus';
            const amountClass = isPlus ? 'tx-amount plus text-emerald-600' : 'tx-amount minus';
            const badgeClass = isPlus ? 'badge-status success' : 'badge-status deducted';
            
            const iconSvg = isPlus 
                ? `<x-lucide-arrow-down-left class="w-3.5 h-3.5" />`
                : `<x-lucide-file-text class="w-3.5 h-3.5" />`;

            const row = document.createElement('tr');
            row.innerHTML = `
                <td>
                    <div class="flex items-center gap-2">
                        <div class="w-6 h-6 rounded ${isPlus ? 'bg-emerald-50 text-emerald-600' : 'bg-slate-100 text-slate-600'} flex items-center justify-center">
                            ${isPlus ? '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="7" y1="17" x2="17" y2="7"></line><polyline points="7 7 17 7 17 17"></polyline></svg>' : '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>'}
                        </div>
                        <span class="font-medium text-slate-800">${item.desc}</span>
                    </div>
                </td>
                <td class="text-xs text-slate-400">${item.date}</td>
                <td class="font-mono text-xs text-slate-400">${item.ref}</td>
                <td class="${amountClass}">${item.amount}</td>
                <td>
                    <span class="${badgeClass}">${item.badge}</span>
                </td>
            `;
            tbody.appendChild(row);
        });

        // Update paginator info
        document.getElementById('paginator-info').innerText = `Showing ${start + 1} to ${end} of ${mockTransactions.length} activities`;
        document.getElementById('btn-prev-page').disabled = (currentPage === 1);
        document.getElementById('btn-next-page').disabled = (currentPage === Math.ceil(mockTransactions.length / itemsPerPage));
    }

    function nextPage() {
        if (currentPage < Math.ceil(mockTransactions.length / itemsPerPage)) {
            currentPage++;
            renderTable();
        }
    }

    function prevPage() {
        if (currentPage > 1) {
            currentPage--;
            renderTable();
        }
    }

    // Checkout modal simulation
    function checkoutSelectedTokens() {
        let qty   = selectedPackageQty;
        let price = selectedPackagePrice;
        
        document.getElementById('modalItemQty').innerText = qty;
        document.getElementById('modalItemPrice').innerText = 'Rp ' + price.toLocaleString('id-ID');

        const modal = document.getElementById('checkoutModal');
        const content = document.getElementById('checkoutModalContent');
        
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        
        setTimeout(() => {
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    function closeCheckoutModal() {
        const modal = document.getElementById('checkoutModal');
        const content = document.getElementById('checkoutModalContent');
        
        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');
        
        setTimeout(() => {
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }, 300);
    }

    function confirmPurchase() {
        const btn = document.getElementById('btnConfirmPurchase');
        btn.disabled = true;
        btn.innerHTML = `<svg class="animate-spin -ml-1 mr-3 h-4.5 w-4.5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Processing...`;

        fetch("{{ route('test_taker.wallet.simulate_purchase') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                qty: selectedPackageQty
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                btn.innerHTML = `<span class="flex items-center gap-1">Success!</span>`;
                setTimeout(() => {
                    window.location.reload();
                }, 800);
            } else {
                alert('Something went wrong. Please try again.');
                btn.disabled = false;
                btn.innerHTML = 'Simulate Pay';
            }
        })
        .catch(err => {
            console.error(err);
            window.location.reload();
        });
    }

    function redeemVoucher() {
        const input = document.getElementById('voucherCode');
        const code = input.value.trim();
        
        if (!code) {
            alert('Please enter a voucher code.');
            return;
        }

        const btn = input.nextElementSibling;
        const originalBtnHtml = btn.innerHTML;
        
        btn.disabled = true;
        btn.innerHTML = `<svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>`;

        fetch("{{ route('test_taker.wallet.redeem_voucher') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ code: code })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                input.value = '';
                alert(data.message + '\\nTokens added: ' + data.tokens_added);
                window.location.reload();
            } else {
                alert(data.message || 'Failed to redeem voucher.');
                btn.disabled = false;
                btn.innerHTML = originalBtnHtml;
            }
        })
        .catch(err => {
            console.error(err);
            alert('An error occurred. Please try again.');
            btn.disabled = false;
            btn.innerHTML = originalBtnHtml;
        });
    }

    // Initialize display states
    document.addEventListener('DOMContentLoaded', () => {
        updatePrice();
        renderTable();
    });
</script>
@endpush
