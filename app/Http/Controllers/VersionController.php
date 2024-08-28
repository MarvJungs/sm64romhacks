<?php

namespace App\Http\Controllers;

use App\Models\Version;
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
        return view('versions/create', ['hack' => $hack]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVersionRequest $request)
    {
        $version = Version::createOrFirst(
            [
                'hack_id' => $request->hack_id,
                'name' => $request->versionname
            ],
            [
                'starcount' => $request->starcount,
                'releasedate' => $request->releasedate ?? '9999-12-31',
                'downloadcount' => 0,
                'filename' => '',
                'recommend' => 0
            ]
        );

        if ($request->hasFile('patchfile') && $version->wasRecentlyCreated) {
            $version->update(['filename' => $request->file('patchfile')->store('patch')]);
        }

        $authors = explode(', ', $request->author);
        foreach ($authors as $author) {
            $version->authors()->createOrFirst(['name' => $author]);
        }

        return redirect('/hacks/' . $request->hack_id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Hack $hack, Version $version)
    {
        Gate::authorize('update', $version);
        $authors = $version->authors()->get()->pluck('name')->implode(', ');
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
        return redirect('/hacks/' . $request->hack_id);
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
            return redirect('/hacks')->with('success', 'The version has successfully been deleted. As the hack has no other versions available, the hack has been deleted as a result');
        }
        return redirect('/hacks/' . $hack->id)->with('success', 'version has successfully been deleted');
    }
}
