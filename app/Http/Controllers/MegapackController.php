<?php

namespace App\Http\Controllers;

use App\Models\Hack;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MegapackController extends Controller
{
    public function index()
    {
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
