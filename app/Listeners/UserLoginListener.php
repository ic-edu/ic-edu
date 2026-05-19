<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class UserLoginListener
{
    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        $user = $event->user;
        $ip = request()->ip();

        // For local development, use a demo IP so the map works during testing
        // In production, this block is skipped and the real IP is used
        if ($ip === '127.0.0.1' || $ip === '::1') {
            // Use a random Indonesian public IP for demo purposes
            $demoIps = [
                '182.1.78.198',   // Bandung - Indihome
                '36.85.128.1',    // Jakarta  - Telkomsel
                '103.80.80.1',    // Surabaya - Biznet
                '180.247.130.1',  // Yogyakarta
                '118.98.224.1',   // Medan
            ];
            $ip = $demoIps[$user->id % count($demoIps)];
        }

        // Only fetch if IP has changed to avoid unnecessary API calls
        if ($user->last_login_ip !== $ip) {
            try {
                // Free IP Geolocation API
                $response = Http::timeout(3)->get("http://ip-api.com/json/{$ip}");
                
                if ($response->successful() && $response->json('status') === 'success') {
                    $data = $response->json();
                    
                    $user->update([
                        'last_login_ip' => $ip,
                        'city' => $data['city'] ?? null,
                        'region' => $data['regionName'] ?? null,
                        'country' => $data['country'] ?? null,
                        'latitude' => $data['lat'] ?? null,
                        'longitude' => $data['lon'] ?? null,
                    ]);
                }
            } catch (\Exception $e) {
                Log::warning('IP Geolocation failed for user ' . $user->id . ': ' . $e->getMessage());
            }
        }
    }
}
