<?php

namespace App\Http\Controllers;

use App\Models\Hack;
use App\Models\Version;
use App\Http\Requests\StoreHackRequest;
use App\Http\Requests\UpdateHackRequest;
use App\Models\Download;
use Illuminate\Http\Request;
use App\Models\Tag;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class HackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $direction = $request->query('direction');
        $sortBy = $request->query('sortBy');

        $tags = Tag::all()->sortBy('name');
        $hacks = Hack::all()->where('verified', '=', '1');

        if ($direction == 'asc') {
            $hacks = $hacks->sortBy($sortBy);
        } elseif ($direction == 'desc') {
            $hacks = $hacks->sortByDesc($sortBy);
        } else {
            $hacks = $hacks->sortBy('name');
        }

        return view('hacks/index', [
            'tags' => $tags,
            'hacks' => $hacks
        ]);
    }

    public function unverified()
    {
        $hacks = Hack::where(['verified' => 0])->orderByDesc('created_at')->orderBy('name')->get();

        return view('hacks.unverified', [
            'hacks' => $hacks
        ]);
    }

    public function manage()
    {
        $hacks = Hack::orderBy('name')->paginate(100);

        return view('hacks.manage', [
            'hacks' => $hacks
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('hacks/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreHackRequest $request)
    {
        $hackData = [
            'name' => $request->name,
            'megapack' => 0,
            'verified' => 0
        ];

        $hack = Hack::createOrFirst($hackData);

        for ($i = 0; $i < $request->count; $i++) {
            $version = $hack->versions()->createOrFirst(
                [
                    'name' => $request->versionname[$i]
                ],
                [
                    'starcount' => $request->starcount[$i],
                    'releasedate' => $request->releasedate[$i] ?? '9999-12-31',
                    'downloadcount' => 0,
                    'recommend' => 0,
                    'filename' => ''
                ]
            );

            if ($request->hasFile('patchfile') && $version->wasRecentlyCreated) {
                $version->update(['filename' => $request->file('patchfile')[$i]->store('patch')]);
            }

            $authors = explode(', ', $request->author[$i]);
            foreach ($authors as $author) {
                $version->authors()->createOrFirst(['name' => $author]);
            }
        }

        if ($request->has('tagname')) {
            $tags = explode(', ', $request->tagname);
            foreach ($tags as $tag) {
                $hack->tags()->createOrFirst(['name' => $tag]);
            }
        }

        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $image) {
                $hack->images()->create(['filename' => $image->store('images/' . $hack->id)]);
            }
        }

        return response()->json([
            'message' => 'Form submitted successfully',
            'request' => json_encode($request->all())], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Hack $hack)
    {
        return view('hacks/view', [
            'hack' => $hack,
            'comments' => $hack->comments->sortByDesc('created_at')
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Hack $hack)
    {
        return view('hacks/edit', ['hack' => $hack]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHackRequest $request, Hack $hack)
    {
        $hack->update([
            'name' => $request->name,
            'description' => $request->description,
            'megapack' => $request->megapack ?? $hack->megapack
        ]);
        return redirect('/hacks/' . $hack->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hack $hack)
    {
        foreach ($hack->images as $image) {
            Storage::delete($image->filename);
        }

        foreach ($hack->versions as $version) {
            Storage::delete($version->filename);
        }

        $hack->delete();
        return redirect('/moderation/hacks/manage')->with('success', 'Hack ' . $hack->name . ' has been deleted');
    }

    public function download(Version $version)
    {
        $hackname = Hack::all()->where('id', '=', $version->hack_id)->first()->name;
        $versionname = $version->name;
        $extension = pathinfo($version->filename, PATHINFO_EXTENSION);
        $version->increment('downloadcount');

        Download::create([
            'version_id' => $version->id,
            'user_id' => Auth::user()?->id
        ]);

        $downloadedFilename = Str::slug(Str::wrap($hackname, '', '-') . $versionname) . '.' . $extension;
        return Storage::download($version->filename, $downloadedFilename);
    }
    public function random()
    {
        $hacks = Hack::all()->unique('id')->where('verified', '=', '1');
        return redirect('hacks/' . $hacks->random()->id);
    }

    public function accept(Request $request)
    {
        $hack = Hack::find($request->hack_id);
        $hack->verified = 1;
        $hack->rejected = 0;
        $hack->save();

        return redirect('/hacks');
    }

    public function reject(Request $request)
    {
        $hack = Hack::find($request->hack_id);
        $hack->verified = 0;
        $hack->rejected = 1;
        $hack->save();

        return redirect('/hacks');
    }
}
