<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class HomeController extends Controller
{
    /**
     * Returns the Homepage
     * 
     * @return RedirectResponse
     */
    public function index(Request $request): RedirectResponse
    {
        return redirect(route('hack.index'));
    }
}
