<?php

namespace App\Http\Controllers;

use App\Models\Hack;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;

class MegapackController extends Controller
{
    public function index()
    {
        SEOMeta::setTitle('Megapack');

        OpenGraph::setTitle('Megapack');
        OpenGraph::setDescription('The Megapack is a collection of the general recommened ROM Hacks by the community. Updated every 6 months.');
        OpenGraph::setType('Hacks');

        $megapackHacks = Hack::all()->where('megapack', '=', true)->where('verified', '=', true)->sortBy('name');
        $easy = $megapackHacks->reject(function (Hack $hack, int $key) {
            return !$hack->tags()->pluck('name')->contains('Easy');
        });

        $normal = $megapackHacks->reject(function (Hack $hack, int $key) {
            return !$hack->tags()->pluck('name')->contains('Normal');
        });

        $advanced = $megapackHacks->reject(function (Hack $hack, int $key) {
            return !$hack->tags()->pluck('name')->contains('Advanced');
        });

        $kaizo = $megapackHacks->reject(function (Hack $hack, int $key) {
            return !$hack->tags()->pluck('name')->contains('Kaizo');
        });

        $megapack = [
            'easy' => $easy,
            'normal' => $normal,
            'advanced' => $advanced,
            'kaizo' => $kaizo
        ];

        return view('megapack.index', ['megapack' => $megapack]);
    }

    public function download(Request $request)
    {
        $megapack_normal = 'Grand Rom Hack Megapack 2024 (Summer Edition)';
        $megapack_kaizo = 'Grand SM64 Kaizo Megapack 2024 (Summer Edition)';

        $type = $request->query('type');

        if ($type == 'normal' || empty($type)) {
            return Storage::download('megapack/' . $megapack_normal . '.zip');
        } else {
            return Storage::download('megapack/' . $megapack_kaizo . '.zip');
        }
    }
}
