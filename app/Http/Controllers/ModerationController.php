<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class ModerationController extends Controller
{
    public function index($section = "default")
    {
        return view('admin.index');
    }
}
