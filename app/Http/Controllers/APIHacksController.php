<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hack;

class APIHacksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hacks = Hack::with([
            'versions:id,hack_id,name,starcount,releasedate,downloadcount,filename',
            'versions.authors:name'
            ])
        ->orderBy('name')
        ->get([
            'hacks.id',
            'hacks.name',
            'hacks.description',
        ]);
        return response()->json($hacks);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $hack = Hack::with([
                'versions:id,hack_id,name,starcount,releasedate,downloadcount,filename',
                'versions.authors:name'
                ])->findOrFail($id, ['hacks.id', 'hacks.name', 'hacks.description']);
            return response()->json($hack);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 404,
                'message' => 'hack was not found'
            ])->setStatusCode(404);
        }
    }
}
