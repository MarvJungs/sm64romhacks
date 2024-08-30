<?php

namespace App\Http\Controllers;

use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;

class PrivacyPolicyController extends Controller
{
    public function index()
    {
        SEOMeta::setTitle('Privacy Policy');

        OpenGraph::setTitle('Privacy Policy');
        OpenGraph::setDescription('Our Privacy Policy');
        OpenGraph::setType('Article');

        return view('privacy-policy.index');
    }
}
