<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Romhack;
use App\Models\Romhacktag;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class RomhacksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hacks = Romhack::with(['versions.authors', 'romhacktags'])->orderBy('name')->get();
        $tags = Romhacktag::all()->sortBy('name');
        return view(
            'hacks.index',
            [
                'hacks' => $hacks,
                'tags' => $tags
            ]
        );
    }

    /**
     * Show the form for creating or editing a resource.
     */
    public function manage(Request $request, ?Romhack $hack)
    {
        if (!$request->user()?->hasRole('admin')) {
            abort(403);
        }
        $tags = Romhacktag::all()->sortBy('name');
        $authors = Author::all()->sortBy('name');

        return view(
            'hacks.manage',
            [
                'authors' => $authors,
                'hack' => $hack,
                'tags' => $tags
            ]
        );
    }

    /**
     * Store a newly created or updated resource in storage.
     */
    public function store(Request $request, ?Romhack $hack)
    {
        if (!$hack->exists) {
            $r = $request->validate(
                [
                    // 'romhack' => 'array:name,description,videolink:version:image',
                    'romhack.name' => 'required|string',
                    'romhack.description' => 'required|json',
                    'romhack.videolink' => 'url|nullable',
                    'romhack.version.name' => 'required|string',
                    'romhack.version.releasedate' => 'required|date',
                    'romhack.version.starcount' => 'required|integer|numeric|gte:0',
                    'romhack.version.patchfile' => 'required|file|filled|extensions:zip',
                    'romhack.version.author.name' => 'required|array|min:1',
                    'romhack.version.author.name.*' => 'required|string|distinct:strict|distinct:ignore_case',
                    'romhack.megapack' => 'boolean'
                    // 'romhack.image' => 'required|array|distinct|min:4',
                    // 'romhack.image.*' => 'required|image'
                ]
            );
            $path = $request->file('romhack.version.patchfile')->store('patch', 'public');
            Arr::set($r, 'romhack.version.filename', $path);
        } else {
            $r = $request->validate(
                [
                    'romhack.name' => 'required|string',
                    'romhack.description' => 'required|json',
                    'romhack.videolink' => 'url|nullable',
                    'romhack.megapack' => 'boolean'
                    // 'romhack.image' => 'required|array|distinct|min:4',
                    // 'romhack.image.*' => 'required|image'
                ]
            );
        }
        Arr::set($r, 'romhack.slug', Str::slug(Arr::get($r, 'romhack.name')));
        if ($hack->exists) {
            $hack->update((Arr::get($r, 'romhack')));
        } else {
            $verify = $request->user()->hasRole('admin');
            Arr::set($r, 'romhack.verify', $verify);
            $hack = Romhack::create((Arr::get($r, 'romhack')));
            $version = $hack->versions()->create((Arr::get($r, 'romhack.version')));
            $version->authors()->detach();
        }
        foreach (Arr::get($r, 'romhack.version.author.name') as $name) {
            $author = Author::firstOrCreate(['name' => $name], ['name' => $name]);
            $version->authors()->attach($author);
        }
        return redirect(route('hack.show', ['hack' => $hack]));
    }

    /**
     * Display the specified resource.
     */
    public function show(Romhack $hack)
    {
        return view('hacks.view')->with('hack', $hack);
    }

    public function random()
    {
        $hack = Romhack::all()->random();
        return $this->show($hack);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Romhack $hack)
    {
        return view('hacks.delete', ['hack' => $hack]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Romhack $hack)
    {
        foreach ($hack->versions as $version) {
            Storage::disk('public')->delete($version->filename);
        }
        $hack->delete();
        dd($hack);
    }
}
