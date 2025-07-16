<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Romhack;
use Illuminate\Support\Facades\Storage;

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

    public function download(Request $request)
    {
        $megapack_normal = 'Grand ROM Hack Megapack 2025 (Summer Edition)';
        $megapack_kaizo = 'Grand SM64 Kaizo Megapack 2025 (Summer Edition)';

        $type = $request->query('type');

        if ($type == 'normal' || empty($type)) {
            $filePath = storage_path('app/public/megapack/' . $megapack_normal . '.zip');
            $headers = [
                'Content-Type' => mime_content_type($filePath),
                'Content-Disposition' => 'attachment; filename="' . basename($filePath) . '"',
            ];
            return response()->stream(
                function () use ($filePath) {
                    $stream = fopen($filePath, 'rb');
                    if ($stream) {
                        while (!feof($stream)) {
                            echo fread($stream, 1024 * 8);
                            flush();
                            ob_flush();
                        }
                        fclose($stream);
                    }
                },
                200,
                $headers
            );
        } else {
            return Storage::download('megapack/' . $megapack_kaizo . '.zip');
        }
    }
}
