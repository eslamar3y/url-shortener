<?php

namespace App\Http\Controllers;

class LandingController extends Controller
{
    public function index()
{
    if (auth()->check()) {
        return redirect('/app');
    }

    return view('landing');
}
}