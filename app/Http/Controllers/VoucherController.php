<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Voucher;
use App\Models\TokenTransaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class VoucherController extends Controller
{
    public function redeem(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        $user = auth()->user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Unauthenticated.'], 401);
        }

        $code = strtoupper(trim($request->code));
        $voucher = Voucher::where('code', $code)->first();

        if (!$voucher) {
            return response()->json(['success' => false, 'message' => 'Invalid voucher code.'], 404);
        }

        if (!$voucher->is_active) {
            return response()->json(['success' => false, 'message' => 'This voucher code is inactive.'], 400);
        }

        if ($voucher->expires_at && $voucher->expires_at->isPast()) {
            return response()->json(['success' => false, 'message' => 'This voucher code has expired.'], 400);
        }

        if ($voucher->max_uses !== null && $voucher->redemptions()->count() >= $voucher->max_uses) {
            return response()->json(['success' => false, 'message' => 'This voucher has reached its maximum usage limit.'], 400);
        }

        if ($user->voucherRedemptions()->where('voucher_id', $voucher->id)->exists()) {
            return response()->json(['success' => false, 'message' => 'You have already claimed this voucher.'], 400);
        }

        try {
            DB::transaction(function () use ($user, $voucher) {
                // Add tokens
                $user->increment('tokens', $voucher->token_amount);

                // Record redemption
                $user->voucherRedemptions()->create([
                    'voucher_id' => $voucher->id,
                ]);

                // Record token transaction history
                TokenTransaction::create([
                    'user_id' => $user->id,
                    'type' => 'credit',
                    'amount' => $voucher->token_amount,
                    'description' => "Redeemed voucher code: {$voucher->code}",
                    'reference_id' => 'VCH-' . strtoupper(Str::random(8)),
                    'status' => 'completed',
                ]);
            });

            return response()->json([
                'success' => true,
                'message' => 'Voucher successfully redeemed!',
                'tokens_added' => $voucher->token_amount,
                'new_balance' => $user->fresh()->tokens,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false, 
                'message' => 'An error occurred while redeeming the voucher. Please try again later.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
