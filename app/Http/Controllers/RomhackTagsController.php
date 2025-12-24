<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateRomhacktagRequest;
use App\Models\Romhacktag;
use Illuminate\Http\Request;

class RomhackTagsController extends Controller
{
    public function index()
    {
        $tags = Romhacktag::all()->sortBy('name');
        return view('admin.romhacktags.index', ['tags' => $tags]);
    }

    public function edit(Romhacktag $tag)
    {
        return view('admin.romhacktags.edit', ['tag' => $tag]);
    }

    public function update(UpdateRomhacktagRequest $request, Romhacktag $tag)
    {
        $r = $request->validated();
        $tag->update(['name' => $r['newName']]);
        return redirect(route('admin.romhacktags.index'));
    }

    public function destroy(Romhacktag $tag)
    {
        $tag->delete();
        return redirect(route('admin.romhacktags.index'));
    }
}
