<?php

namespace App\Http\Controllers;

use App\Models\Hack;
use App\Models\Version;
use App\Http\Requests\StoreHackRequest;
use App\Http\Requests\UpdateHackRequest;
use App\Models\Author;
use App\Models\Download;
use Illuminate\Http\Request;
use App\Models\Tag;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Http\File;

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

        SEOMeta::setTitle('Hacks');

        OpenGraph::setTitle('Hacks');
        OpenGraph::setDescription('An Overview of all the SM64 ROM Hacks we offer, free to download!');
        OpenGraph::setType('Overview');

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
        Gate::authorize('create', Hack::class);
        $tags = Tag::all()->pluck('name')->toArray();
        $authors = Author::all()->sortBy('name')->pluck('name')->toArray();

        return view('hacks/create', compact('tags', 'authors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreHackRequest $request)
    {
        if ($request->file('patchfile')->getClientOriginalExtension() != 'zip') {
            return back()->with('error', 'not a zip-file');
        }

        $hackData = [
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'megapack' => 0,
            'verified' => 0
        ];

        $hack = Hack::createOrFirst($hackData);

        $version = $hack->versions()->createOrFirst(
            [
                'name' => $request->versionname
            ],
            [
                'starcount' => $request->starcount ?? 0,
                'releasedate' => $request->releasedate ?? '9999-12-31',
                'downloadcount' => 0,
                'recommened' => 0,
                'filename' => ''
            ]
        );

        if ($request->hasFile('patchfile') && $version->wasRecentlyCreated) {
            $version->update(['filename' => $request->file('patchfile')->store('patch')]);
        }

        foreach ($request->author as $author) {
            $version->authors()->createOrFirst(['name' => $author]);
        }


        if ($request->has('tagname')) {
            foreach ($request->tagname as $tag) {
                if (!is_null($tag)) {
                    $hack->tags()->createOrFirst(['name' => $tag]);
                }
            }
        }

        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $image) {
                $hack->images()->create(['filename' => $image->store('images/' . $hack->id)]);
            }
        }

        return redirect(route('hacks.index'))->with('success', 'hack has successfully been submitted for review');
    }

    /**
     * Display the specified resource.
     */
    public function show(Hack $hack)
    {

        OpenGraph
            ::setTitle($hack->name)
            ->setType('Article')
            ->setDescription(getOpenGraphText($hack->description));

        foreach ($hack->images as $image) {
            OpenGraph::addImage(env('APP_URL') . '/' . $image->filename);
        }

        SEOMeta::setTitle($hack->name);

        $versions = $hack->versions->sort(function ($a, $b) {

            $recommenedComparison = $b['recommened'] - $a['recommened'];
            if ($recommenedComparison !== 0) {
                return $recommenedComparison;
            }

            if ($a['releasedate'] === '9999-12-31') {
                return 1;
            }

            if ($b['releasedate'] === '9999-12-31') {
                return -1;
            }

            $dateComparison = strtotime($b['releasedate']) - strtotime($a['releasedate']);
            if ($dateComparison !== 0) {
                return $dateComparison;
            }

            return $a['demo'] - $b['demo'];
        });

        return view('hacks/view', [
            'hack' => $hack,
            'versions' => $versions,
            'comments' => $hack->comments->sortByDesc('created_at')
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Hack $hack)
    {
        Gate::authorize('update', $hack);
        $tags = Tag::all()->pluck('name')->toArray();
        return view('hacks/edit', [
            'hack' => $hack,
            'tags' => $tags
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHackRequest $request, Hack $hack)
    {
        $recommened_versions = $request->recommened;
        $demo_versions = $request->demo;

        foreach ($hack->versions as $version) {
            $version->update([
                'recommened' => 0,
                'demo' => 0
            ]);
        }

        if (!is_null($recommened_versions)) {
            foreach ($recommened_versions as $recommened_version) {
                Version::find($recommened_version)->update([
                    'recommened' => 1
                ]);
            }
        }

        if (!is_null($demo_versions)) {
            foreach ($demo_versions as $demo_version) {
                Version::find($demo_version)->update([
                    'demo' => 1
                ]);
            }
        }

        $hack->tags()->detach();
        if ($request->has('tagname')) {
            $tags = $request->tagname;
            foreach ($tags as $tag) {
                $hack->tags()->createOrFirst(['name' => $tag]);
            }
        }

        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $image) {
                $hack->images()->create([
                    'filename' => Storage::putFile("images/$hack->id", new File($image))
                ]);
            }
        }


        $hack->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'megapack' => $request->megapack ?? $hack->megapack,
            'videolink' => $request->videolink
        ]);
        return redirect(route('hacks.show', $hack));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hack $hack)
    {
        Gate::authorize('forceDelete', $hack);
        foreach ($hack->images as $image) {
            Storage::delete($image->filename);
        }

        foreach ($hack->versions as $version) {
            Storage::delete($version->filename);
        }

        $hack->delete();
        return redirect(route('hacks.manage'))->with('success', 'Hack ' . $hack->name . ' has been deleted');
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
        $hack = Hack::where('verified', '=', '1')->get()->random();
        return redirect(route('hacks.show', $hack));
    }

    public function accept(Request $request)
    {
        $hack = Hack::find($request->hack_id);
        $hack->verified = 1;
        $hack->rejected = 0;
        $hack->save();

        return redirect(route('hacks.index'));
    }

    public function reject(Request $request)
    {
        $hack = Hack::find($request->hack_id);
        $hack->verified = 0;
        $hack->rejected = 1;
        $hack->save();

        return redirect(route('hacks.index'));
    }
}
