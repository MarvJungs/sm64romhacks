<?php

namespace App\Http\Controllers;

use App\Models\Version;
use App\Models\Author;
use App\Models\Hack;
use App\Http\Requests\StoreVersionRequest;
use App\Http\Requests\UpdateVersionRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class VersionController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create(Hack $hack)
    {
        Gate::authorize('create', Version::class);
        $authors = Author::all()->sortBy('name')->pluck('name')->toArray();
        return view('versions/create', compact('hack', 'authors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVersionRequest $request, Hack $hack)
    {
        if ($request->file('patchfile')->getClientOriginalExtension() != 'zip') {
            return back()->with('error', 'not a zip-file');
        }

        $version = Version::createOrFirst(
            [
                'hack_id' => $hack->id,
                'name' => $request->versionname
            ],
            [
                'starcount' => $request->starcount,
                'releasedate' => $request->releasedate ?? '9999-12-31',
                'downloadcount' => 0,
                'filename' => '',
                'recommened' => 0,
                'demo' => 0
            ]
        );

        if ($request->hasFile('patchfile') && $version->wasRecentlyCreated) {
            $version->update(['filename' => $request->file('patchfile')->store('patch')]);
        }

        foreach ($request->author as $author) {
            if (!is_null($author)) {
                $version->authors()->createOrFirst(['name' => $author]);
            }
        }

        return redirect(route('hacks.show', $version->hack));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Hack $hack, Version $version)
    {
        Gate::authorize('update', $version);
        $authors = Author::all()->sortBy('name')->pluck('name')->toArray();
        return view('versions/edit', ['hack' => $hack, 'version' => $version, 'authors' => $authors]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVersionRequest $request, Hack $hack, Version $version)
    {
        $version->update([
            'name' => $request->versionname,
            'starcount' => $request->starcount,
            'releasedate' => $request->releasedate
        ]);
        $version->authors()->detach();
        foreach ($request->author as $author) {
            if (!is_null($author)) {
                $version->authors()->createOrFirst(['name' => $author]);
            }
        }
        return redirect(route('hacks.show', $hack));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hack $hack, Version $version)
    {
        Gate::authorize('delete', $version);
        Storage::delete($version->filename);
        $version->delete();

        if (sizeof($hack->versions) == 0) {
            foreach ($hack->images as $image) {
                Storage::delete($image->filename);
            }
            $hack->delete();
            return redirect(route('hacks.index'))->with('success', 'The version has successfully been deleted. As the hack has no other versions available, the hack has been deleted as a result');
        }
        return redirect(route('hacks.show', $hack))->with('success', 'version has successfully been deleted');
    }
}
