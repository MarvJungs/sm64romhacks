<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Http\Requests\StoreNewsRequest;
use App\Http\Requests\UpdateNewsRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        SEOMeta::setTitle('News');

        OpenGraph::setTitle('News');
        OpenGraph::setDescription('An Overview of the recent news going on concerning the community.');
        OpenGraph::setType('Articles');

        $news = News::orderByDesc('created_at')->paginate(15);

        return view('news.index', [
            'news' => $news
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', News::class);
        return view('news.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNewsRequest $request)
    {
        $news = News::create([
            'user_id' => Auth::user()->id,
            'title' => $request->title,
            'text' => $request->text,
            'important' => filter_var($request->important, FILTER_VALIDATE_BOOLEAN)
        ]);

        return redirect(route('news.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(News $news)
    {
        SEOMeta::setTitle('News');

        OpenGraph::setTitle('News');
        OpenGraph::setDescription(getOpenGraphText($news->text));
        OpenGraph::setType('Article');

        return view('news.show', [
            'news' => $news
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(News $news)
    {
        Gate::authorize('update', $news);
        return view('news.edit', [
            'news' => $news
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNewsRequest $request, News $news)
    {
        $news->update([
            'title' => $request->title,
            'text' => $request->text,
            'important' => filter_var($request->important, FILTER_VALIDATE_BOOLEAN),
        ]);

        return redirect(route('news.index'))->with('success', 'newspost has been updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(News $news)
    {
        Gate::authorize('delete', $news);
        $news->delete();
        return redirect(route('news.index'))->with('success', 'newspost has been deleted');
    }
}
