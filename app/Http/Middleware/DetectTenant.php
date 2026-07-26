<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class DetectTenant
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $host = $request->getHost();
        $domains = config('tenant.domains', []);
        
        $tenantId = $domains[$host] ?? config('tenant.default', 'ic_edu');
        
        // Simpan data tenant yang aktif di config agar bisa diakses di manapun (blade, dll)
        config(['tenant.active_id' => $tenantId]);
        config(['tenant.active' => config("tenant.data.{$tenantId}")]);
        
        return $next($request);
    }
}
