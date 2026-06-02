<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('notifications:prune', function () {
    // 1. Delete notifications that were read more than 7 days ago
    $prunedRead = Illuminate\Support\Facades\DB::table('notifications')
        ->whereNotNull('read_at')
        ->where('read_at', '<', now()->subDays(7))
        ->delete();

    // 2. Delete any notification (including unread) older than 30 days
    $prunedOld = Illuminate\Support\Facades\DB::table('notifications')
        ->where('created_at', '<', now()->subDays(30))
        ->delete();

    $total = $prunedRead + $prunedOld;
    $this->info("Notifications pruned: {$total} total ({$prunedRead} read older than 7 days, {$prunedOld} older than 30 days).");
})->purpose('Prune read notifications older than 7 days and extremely old unread notifications')->daily();
