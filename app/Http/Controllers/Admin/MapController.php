<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class MapController extends Controller
{
    public function index()
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            abort(403);
        }

        $locations = User::whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->select('name', 'city', 'latitude', 'longitude')
            ->get()
            ->toArray();

        return view('admin.geo_map', compact('locations'));
    }
}
