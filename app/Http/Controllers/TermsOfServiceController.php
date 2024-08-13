<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TermsOfServiceController extends Controller
{
    public function index() {
        return view('tos.index');
    }
}
