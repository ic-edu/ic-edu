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
            \App\Models\TokenTransaction::firstOrCreate(
                [
                    'user_id' => $user->id,
                    'description' => 'Initial Account Token Credit',
                ],
                [
                    'type' => 'purchase',
                    'amount' => $user->tokens,
                    'reference_id' => 'TXN-INIT-' . strtoupper(\Illuminate\Support\Str::random(6)),
                    'status' => 'completed',
                ]
            );
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

    public function submitTopUp(Request $request)
    {
        $request->validate([
            'qty' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'method' => 'required|in:transfer,cash',
            'proof' => 'required_if:method,transfer|image|max:2048', // max 2MB
        ]);

        /** @var \App\Models\User $user */
        $user = auth()->user();

        $proofPath = null;
        if ($request->hasFile('proof')) {
            $proofPath = $request->file('proof')->store('topup_proofs', 'public');
        }

        \App\Models\TopUpRequest::create([
            'user_id' => $user->id,
            'amount' => $request->input('qty'),
            'price' => $request->input('price'),
            'method' => $request->input('method'),
            'proof_path' => $proofPath,
            'status' => 'pending',
        ]);

        $message = $request->input('method') === 'cash' 
            ? 'Top Up diajukan. Silakan serahkan uang tunai kepada admin di lokasi agar token segera diproses.'
            : 'Bukti transfer berhasil diunggah. Top Up Anda sedang menunggu persetujuan admin.';

        return response()->json([
            'success' => true,
            'message' => $message
        ]);
    }
}
