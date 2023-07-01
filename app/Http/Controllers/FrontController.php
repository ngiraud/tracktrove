<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class FrontController extends Controller
{
    public function homepage(): View
    {
        return view('homepage');
    }
}
