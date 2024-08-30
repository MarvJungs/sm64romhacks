<?php

namespace App\Http\Controllers;

use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;

class PatchController extends Controller
{
    public function index()
    {
        SEOMeta::setTitle('Online Patcher');

        OpenGraph::setTitle('Online Patcher');
        OpenGraph::setDescription('This is an Online Patcher where you can manually patch your downloaded file or let an patch from our website autopatch it!');
        OpenGraph::setType('Patcher');

        return view('patcher.index');
    }
}
