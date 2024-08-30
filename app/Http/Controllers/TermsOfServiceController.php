<?php

namespace App\Http\Controllers;

use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;

class TermsOfServiceController extends Controller
{
    public function index()
    {
        SEOMeta::setTitle('Terms Of Service');

        OpenGraph::setTitle('Terms Of Service');
        OpenGraph::setDescription('Our Terms Of Services');
        OpenGraph::setType('Article');

        return view('tos.index');
    }
}
