<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Version;

class APIVersionController extends Controller
{
    public function show(string $id)
    {
        try {
            $version = Version::with('hack')->findOrFail($id);
            return response()->json($version);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 404,
                'message' => 'version was not found'
            ])->setStatusCode(404);
        }
    }
}
