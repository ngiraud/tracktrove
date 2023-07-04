<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    public function redirect(Request $request): RedirectResponse
    {
        $request->session()->put('spotify.redirect_to', $request->header('referer'));

        return Socialite::driver('spotify')->redirect();
    }

    public function callback(Request $request): RedirectResponse
    {
        $user = Socialite::driver('spotify')->user();

        $request->user()->update(['spotify_token' => $user->token]);

        $redirectTo = $request->session()->get('spotify.redirect_to', route('profile.edit'));

        $request->session()->remove('spotify.redirect_to');

        return redirect()->to($redirectTo)->with('status', 'music-platform-updated');
    }
}
