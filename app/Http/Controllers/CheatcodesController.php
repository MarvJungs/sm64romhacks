<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCheatcodeRequest;
use App\Http\Requests\UpdateCheatcodeRequest;
use App\Models\Cheatcode;
use Illuminate\Http\Request;

class CheatcodesController extends Controller
{
    public function index()
    {
        $cheatcodes = Cheatcode::all()->sortBy('name');
        return view('cheats.index', ['cheatcodes' => $cheatcodes]);
    }

    public function create()
    {
        return view('admin.cheats.create');
    }

    public function store(StoreCheatcodeRequest $request)
    {
        Cheatcode::createOrFirst($request->validated());
        return redirect(route('cheats.index'));
    }

    public function edit(Cheatcode $cheatcode)
    {
        return view('admin.cheats.edit', ['cheatcode' => $cheatcode]);
    }

    public function update(UpdateCheatcodeRequest $request, Cheatcode $cheatcode)
    {
        $cheatcode->update($request->validated());
        return redirect(route('cheats.index'));
    }

    public function destroy(Cheatcode $cheatcode)
    {
        $cheatcode->delete();
        return view('cheats.index');
    }
}
