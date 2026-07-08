<?php

namespace App\Filament\Widgets;

use App\Models\CourseEnrollment;
use App\Models\TokenTransaction;
use App\Models\VoucherRedemption;
use Filament\Widgets\Widget;

class FinancialOverviewWidget extends Widget
{
    protected string $view = 'filament.widgets.financial-overview';
    protected static ?int $sort = 2;

    protected int | array | string $columnSpan = 'full';

    public static function canView(): bool
    {
        return auth()->user()->isSuperAdmin();
    }

    protected function getViewData(): array
    {
        // 1. Course calculations
        $totalCoursePurchases = CourseEnrollment::count();
        // Course enrollments no longer generate IDR revenue, they burn tokens

        // 2. Token calculations
        $tokenTx = TokenTransaction::where('type', 'purchase')->where('status', 'completed')->get();
        $totalTokenPurchasesCount = $tokenTx->count();
        $totalTokensPurchased = abs($tokenTx->sum('amount'));
        
        $tokenRevenue = 0;
        
        $price1 = (int) \App\Models\Setting::get('token_price_per_unit', 99000);
        $price3 = (int) \App\Models\Setting::get('token_package_3_price', 249000);
        $price5 = (int) \App\Models\Setting::get('token_package_5_price', 399000);

        foreach ($tokenTx as $t) {
            $amount = abs($t->amount);
            if ($amount === 1) {
                $tokenRevenue += $price1;
            } elseif ($amount === 3) {
                $tokenRevenue += $price3;
            } elseif ($amount === 5) {
                $tokenRevenue += $price5;
            } else {
                $tokenRevenue += $amount * $price1;
            }
        }

        // 3. Voucher calculations
        $totalVoucherRedemptions = VoucherRedemption::count();
        $tokensRedeemed = TokenTransaction::where('type', 'credit')
            ->where('status', 'completed')
            ->sum('amount');
        
        // Estimate promotional equivalent value (tokens * price_per_unit)
        $equivalentPromoValue = $tokensRedeemed * $price1;

        // 4. Combined calculations
        $grandTotalRevenue = $tokenRevenue;

        // 5. Recent enrollments and token transactions for display
        $recentEnrollments = CourseEnrollment::with(['user', 'course'])
            ->latest()
            ->take(4)
            ->get();

        $recentTransactions = TokenTransaction::with('user')
            ->where('type', 'purchase')
            ->latest()
            ->take(4)
            ->get();

        return [
            'courseCount' => $totalCoursePurchases,
            'courseRevenue' => 0, // Deprecated
            'tokenCount' => $totalTokenPurchasesCount,
            'tokensPurchased' => $totalTokensPurchased,
            'tokenRevenue' => $tokenRevenue,
            'voucherCount' => $totalVoucherRedemptions,
            'tokensRedeemed' => $tokensRedeemed,
            'equivalentPromoValue' => $equivalentPromoValue,
            'grandTotalRevenue' => $grandTotalRevenue,
            'recentEnrollments' => $recentEnrollments,
            'recentTransactions' => $recentTransactions,
        ];
    }
}
