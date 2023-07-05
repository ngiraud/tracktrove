<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): View
    {
        return view('dashboard', [
            'followersCount' => $request->user()?->library?->followers()->count(),
            'followingCount' => $request->user()->following()?->count(),
            'albumsCount' => $request->user()?->library?->albums()->count(),
            'topAlbums' => Album::with(['artist'])->withCount('libraries')->orderByDesc('libraries_count')->take(20)->get(),
            'albumIds' => $request->user()?->library?->albums()->pluck('id'),
        ]);
    }
}
