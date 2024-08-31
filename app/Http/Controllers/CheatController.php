<?php

namespace App\Http\Controllers;

use App\Models\Cheat;
use App\Http\Requests\StoreCheatRequest;
use App\Http\Requests\UpdateCheatRequest;
use Illuminate\Support\Facades\Gate;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;

class CheatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        SEOMeta::setTitle('Cheat Codes');

        OpenGraph::setTitle('Cheat Codes');
        OpenGraph::setDescription('An Overview of commonly used cheat codes ready to use!');
        OpenGraph::setType('Cheat Codes');

        $cheats = Cheat::all();
        return view('cheats.index', ['cheats' => $cheats]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', Cheat::class);
        return view('cheats.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCheatRequest $request)
    {
        $cheat = Cheat::where(['title' => $request->title])->get();
        if (sizeof($cheat) == 0) {
            $cheat = Cheat::create([
                'title' => $request->title,
                'description' => $request->description,
                'code' => $request->code
            ]);
            $cheat->save();
            return redirect(route('cheats.index'))->with('success', 'code added');
        }
        return redirect(route('cheats.index'))->with('error', 'code already exists');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cheat $cheat)
    {
        Gate::authorize('update', $cheat);
        return view('cheats.edit', ['cheat' => $cheat]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCheatRequest $request, Cheat $cheat)
    {
        $cheat->display_name = $request->display_name;
        $cheat->description = $request->description;
        $cheat->code = $request->code;
        $cheat->update();

        return redirect(route('cheats.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cheat $cheat)
    {
        Gate::authorize('delete', $cheat);
        $cheat->delete();
    }
}
