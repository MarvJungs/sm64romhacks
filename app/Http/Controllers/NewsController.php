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

        $request = Http::post(env('DISCORD_WEBHOOK_URI'), [
            'content' => $news->important ? '@everyone' : null,
            'username' => 'sm64romhacks News',
            'avatar_url' => 'https://static-cdn.jtvnw.net/jtv_user_pictures/f6dd682a-ce61-40d1-ab3a-54dc6c174092-profile_image-70x70.png',
            'embeds' => [
                [
                    'title' => mb_strlen($news->title) > 256 ? mb_substr($news->title, 0, 256 - 3) . '...' : $news->title,
                    'type' => 'rich',
                    'description' => mb_strlen(getDiscordEmbedText($news->text)) > 4096 ? mb_substr(getDiscordEmbedText($news->text), 0, 4096 - 3) . '...' : getDiscordEmbedText($news->text),
                    'url' => 'https://www.sm64romhacks.com/news/' . $news->id,
                    'timestamp' => Carbon::now(),
                    'color' => rand(0x000000, 0xFFFFFF),
                    'footer' => [
                        'text' => 'This is an official sm64romhacks message. These messages will never be sent out by a different service other than sm64romhacks.com. Be careful where the links leads to.',
                        'icon_url' => 'https://www.sm64romhacks.com/_assets/_img/icon.ico'
                    ],
                    'author' => [
                        'name' => 'sm64romhacks',
                        'url' => 'https://www.sm64romhacks.com',
                        'icon_url' => 'https://www.sm64romhacks.com/_assets/_img/logo.png'
                    ],
                    "fields" => [
                        [
                            "name" => "Category",
                            "value" => "[News](https://www.sm64romhacks.com/news)",
                            "inline" => true
                        ],
                        [
                            "name" => "Author",
                            "value" => Auth::user()->global_name,
                            "inline" => true
                        ]
                    ],
                ]
            ],
            'allowed_mentions' => [
                'parse' => [
                    'everyone'
                ]
            ],
        ]);

        return redirect('news');
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

        return redirect('/news')->with('success', 'newspost has been updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(News $news)
    {
        Gate::authorize('delete', $news);
        $news->delete();
        return redirect('/news')->with('success', 'newspost has been deleted');
    }
}
