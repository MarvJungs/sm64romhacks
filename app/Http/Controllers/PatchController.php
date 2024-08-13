<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PatchController extends Controller
{
    public function index() {
        return view('patcher.index');
    }
}
