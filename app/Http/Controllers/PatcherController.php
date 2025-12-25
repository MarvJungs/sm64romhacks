<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PatcherController extends Controller
{
    /**
     * Returns the Patcher Site
     * 
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('patcher.index');
    }
}
