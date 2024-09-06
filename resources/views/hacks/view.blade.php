<x-layout>
    <h1 class="text-center">
        <span class="text-decoration-underline">
            {{ $hack->name }}
        </span>
        @if (Auth::check() &&
                (Auth::user()->isAuthorOfHack($hack) ||
                    Auth::user()->isAdmin() ||
                    Auth::user()->isModerator() ||
                    Auth::user()->isSiteHelper()))
            &nbsp;<a href="{{ route('hacks.edit', $hack) }}" class="btn btn-primary">
                <span class="fa-solid fa-pen"></span> Edit Hack
            </a> &nbsp;
            <a href="{{ route('version.create', $hack) }}" class="btn btn-success">
                <span class="fa-solid fa-plus"></span> Add Version
            </a>
        @endif
    </h1>

    <table class="table">
        <x-table.versions.head />
        <tbody>
            @foreach ($versions as $version)
                <x-table.versions.row :version="$version" />
            @endforeach
        </tbody>
    </table>
    @if ($hack->description && $hack->description != '[]')
        <div class="card">
            <div class="card-body">
                @foreach (json_decode($hack->description) as $item)
                    {!! parseEditorText($item) !!}
                @endforeach
            </div>
        </div>
    @endif
    <div class="row mb-4">
        <div class="col">
            @if ($hack->videolink && !empty($_COOKIE['hasConsent']) && $_COOKIE['hasConsent'] == true)
                <iframe
                    src="https://www.youtube.com/embed/{{ getYoutubeVideoID($hack->videolink) }}"
                    width="560" height="315" title="YouTube video player" frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            @else
                <svg class="mb-4" width="560" height="315" xmlns="http://www.w3.org/2000/svg">
                    <rect height="100%" width="100%" fill="#1d1d1d" />
                    <image width="160" height="90" x="200" y="72" href="{{ env('APP_URL') }}/images/logo.png" />
                    <text x="95" y="190" fill="#aeaeae" font-size="36">The Video is unavailable.</text>
                    <text x="5" y="236" fill="#6c6c6c">HTTP ERROR 502: PUP KAG DQMXXK FTUZW U IAGXP BGF HMXGQMNXQ</text>
                    <text x="5" y="256" fill="#6c6c6c">UZRADYMFUAZ TQDQ? FTMF IAGXP NQ DQMXXK RGZZK NGF FTUE</text>
                    <text x="5" y="276" fill="#6c6c6c">YQEEMSQ DQMXXK AZXK QJUEFE FA SUHQ KAG EXQQBXQEE ZUSTFE</text>
                    <text x="5" y="296" fill="#6c6c6c">MNAGF ITMF FTUE YQEEMSQ OAGXP YQMZ.</text>
                </svg>
            @endif
        </div>
        <div class="col">
            @if (sizeof($hack->images) > 0)
                <div class="carousel slide carousel-fade" id="imageSlider" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @foreach ($hack->images as $index => $image)
                            @if ($index == 0)
                                <div class="carousel-item active" data-bs-interval="5000">
                                @else
                                    <div class="carousel-item" data-bs-interval="5000">
                            @endif
                            <img src="{{ Storage::url($image->filename) }}" class="d-block w-100" height="315">
                    </div>
            @endforeach
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#imageSlider" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#imageSlider" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    </div>
@else
    <svg class="mb-4" width="560" height="315" xmlns="http://www.w3.org/2000/svg">
        <rect height="100%" width="100%" fill="#1d1d1d" />
        <image width="160" height="90" x="200" y="72" href="{{ env('APP_URL') }}/images/logo.png" />
        <text x="95" y="190" fill="#aeaeae" font-size="36">No Images are available.</text>

        <text x="5" y="236" fill="#6c6c6c">HTTP ERROR 404: O UO IWM ISOH HZE POP EHSQD HLKZV YJCK RNMP </text>
        <text x="5" y="256" fill="#6c6c6c">EJEZNB BH AWANV LNZS XWWC FS T CWGCLT PTTJ NZEZOEG OW MCQL JZM </text>
        <text x="5" y="276" fill="#6c6c6c">NVRZ. Q AMUE JZM KEJJGXB YHTD DOKTGM KGIDWP STU NJE ZM TUEDAJV </text>
        <text x="5" y="296" fill="#6c6c6c">OM AHKJTSTFM. MNAGF ITMF FTUE YQEEMSQ OAGXP YQMZ.</text>
    </svg>
    @endif
    </div>

    <hr />

    @if (Auth::check())
        <div class="accordion mb-4" id="accordion">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                        data-bs-target="#addComment" aria-expanded="false" aria-controls="addComment">
                        Add Comment
                    </button>
                </h2>
                <div id="addComment" class="accordion-collapse collapse" data-bs-parent="#accordion">
                    <div class="accordion-body">

                        <form action="/comments" method="post">
                            @csrf
                            <input type="hidden" name="hack_id" value="{{ $hack->id }}">
                            <label for="title">Title</label>
                            <input class="form-control mb-4" type="text" name="title" id="title" required>

                            <label for="text">Comment</label>
                            <textarea class="form-control mb-4" name="text" id="text" cols="15" rows="10" required></textarea>

                            <button class="btn btn-primary w-100 mb-4" type="submit">Save Comment</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div id="comments">
        <h2>Comments</h2>
        @if (sizeof($comments) > 0)
            @foreach ($comments as $comment)
                <x-cards.hack-comment :comment="$comment" />
            @endforeach
        @else
            <em>No Comments found</em>
        @endif
    </div>
</x-layout>
