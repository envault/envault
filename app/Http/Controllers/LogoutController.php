<?php

namespace App\Http\Controllers;

class LogoutController extends Controller
{
    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke()
    {
        auth()->logout();

        return redirect()->route('home');
    }
}
