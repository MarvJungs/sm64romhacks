<?php

namespace App\Http\Controllers;

use App\Models\Romhack;

class MegapackController extends Controller
{
    public function index()
    {
        $megapackHacks = Romhack::all()->where('megapack', '=', true)->where('verified', '=', true)->sortBy('name');
        $easy = $megapackHacks->reject(
            function (Romhack $hack, int $key) {
                return !$hack->romhacktags()->pluck('name')->contains('Easy');
            }
        );

        $normal = $megapackHacks->reject(
            function (Romhack $hack, int $key) {
                return !$hack->romhacktags()->pluck('name')->contains('Normal');
            }
        );

        $advanced = $megapackHacks->reject(
            function (Romhack $hack, int $key) {
                return !$hack->romhacktags()->pluck('name')->contains('Advanced');
            }
        );

        $kaizo = $megapackHacks->reject(
            function (Romhack $hack, int $key) {
                return !$hack->romhacktags()->pluck('name')->contains('Kaizo');
            }
        );

        $megapack = [
            'easy' => $easy,
            'normal' => $normal,
            'advanced' => $advanced,
            'kaizo' => $kaizo
        ];

        return view('megapack.index', ['megapack' => $megapack]);
    }
}
