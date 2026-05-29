<?php

namespace App\Http\Controllers\TestTaker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Str;

class WalletController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        
        // Auto-populate transaction history for initial seeded balance if missing
        if (($user->tokens ?? 0) > 0 && $user->tokenTransactions()->count() === 0) {
            \App\Models\TokenTransaction::create([
                'user_id' => $user->id,
                'type' => 'purchase',
                'amount' => $user->tokens,
                'description' => 'Initial Account Token Credit',
                'reference_id' => 'TXN-INIT-' . strtoupper(Str::random(6)),
                'status' => 'completed',
            ]);
        }
        
        $transactions = $user->tokenTransactions()->latest()->get();
        $mappedTransactions = $transactions->map(function($t) {
            return [
                'desc' => $t->description,
                'date' => $t->created_at->format('M d, Y'),
                'ref' => $t->reference_id,
                'amount' => ($t->amount > 0 ? '+' : '') . $t->amount . ' Token' . (abs($t->amount) != 1 ? 's' : ''),
                'type' => in_array($t->type, ['purchase', 'credit']) ? 'plus' : 'deducted',
                'badge' => $t->type === 'purchase' ? 'Purchased' : ($t->type === 'credit' ? 'Redeemed' : 'Deducted')
            ];
        });

        $tokenPrice     = (int) Setting::get('token_price_per_unit', config('tokens.price_per_unit', 99000));
        $package3Price  = (int) Setting::get('token_package_3_price', 249000);
        $package5Price  = (int) Setting::get('token_package_5_price', 399000);

        return view('test_taker.wallet', compact('mappedTransactions', 'tokenPrice', 'package3Price', 'package5Price'));
    }

    public function simulatePurchase(Request $request)
    {
        // TODO: REMOVE THIS ROUTE ONCE PAYMENT GATEWAY IS IMPLEMENTED
        if (app()->environment('production')) {
            abort(404, 'Simulation is not available in production.');
        }

        $qty = (int) $request->input('qty', 1);
        /** @var \App\Models\User $user */
        $user = auth()->user();
        $user->tokens = ($user->tokens ?? 0) + $qty;
        $user->save();

        // Create token transaction record
        \App\Models\TokenTransaction::create([
            'user_id' => $user->id,
            'type' => 'purchase',
            'amount' => $qty,
            'description' => 'Token Purchase (Top Up)',
            'reference_id' => 'TXN-' . strtoupper(Str::random(8)),
            'status' => 'completed',
        ]);

        // Create notification for the user
        $user->notify(new \App\Notifications\GeneralNotification([
            'title' => 'Successfully purchased <strong>' . $qty . ' Token' . ($qty != 1 ? 's' : '') . '</strong>',
            'desc' => 'Your payment was verified. ' . $qty . ' universal token' . ($qty != 1 ? 's' : '') . ' added to your balance.',
            'type' => 'system',
            'category' => 'Token Top Up',
            'action_url' => route('test_taker.wallet'),
            'action_text' => 'View Wallet →'
        ]));

        return response()->json(['success' => true, 'new_balance' => $user->tokens]);
    }
}
