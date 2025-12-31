<x-layout :seoModel="$hack">
    <div class="d-flex justify-content-between align-items-center gap-3">
        <h1 class="text-decoration-underline">
            {{ $hack->name }}
        </h1>

        <div>
            @can('update', $hack)
                <a href="{{ route('hack.edit', ['hack' => $hack]) }}" class="btn btn-secondary" data-bs-toggle="tooltip"
                    data-bs-placement="top" data-bs-title="Edit Hack">
                    <x-bi-pencil />
                </a>
            @endcan

            @can('delete', $hack)
                <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete Hack">
                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modal-confirm"
                        data-bs-route="{{ route('hack.destroy', ['hack' => $hack]) }}" data-bs-method="DELETE">
                        <x-bi-trash />
                    </button>
                </span>
            @endcan
            <button type="button" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top"
                data-bs-title="Copy Link"
                onclick="navigator.clipboard.writeText('{{ route('hack.show', ['hack' => $hack]) }}')"><x-bi-clipboard /></button>
        </div>
    </div>

    <section id="tags">
        @foreach ($hack->romhacktags as $tag)
            <span class="badge rounded-pill text-bg-secondary">{{ $tag->name }}</span>
        @endforeach
    </section>
    <hr />

    <section id="description">
        @if ($hack->description !== null)
            <x-editor-js :blocks="$hack->description['blocks']" />
        @endif
    </section>

    <x-romhack.versions-table :hack="$hack" />

    <hr />

    <div class="row text-center align-items-center">
        <section class="col ratio ratio-4x3 border" id="video">
            @if ($hack->videolink)
                <p class="top-50">{{ $hack->videolink }}</p>
            @else
                <p class="top-50">No video found :(</p>
            @endif
        </section>
        <section class="col ratio ratio-4x3 border" id="images">
            @if (sizeof($hack->images) > 0)
                <div class="carousel carousel-dark slide" id="diashow" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        @for ($i = 0; $i < sizeof($hack->images); $i++)
                            <button type="button" data-bs-target="diashow" data-bs-slide-to="{{ $i }}"
                                @if ($i == 0) class="active" aria-current="true" @endif
                                aria-label="Slide {{ $i + 1 }}"></button>
                        @endfor
                    </div>
                    <div class="carousel-inner">
                        @foreach ($hack->images as $index => $image)
                            <div
                                class="carousel-item position-relative @if ($index == 0) active @endif">
                                @can('update', $hack)
                                    <button type="button" class="btn btn-danger position-absolute top-0 end-0"
                                        data-bs-toggle="modal" data-bs-target="#modal-confirm"
                                        data-bs-route="{{ route('image.destroy', ['hack' => $hack, 'image' => $image]) }}"
                                        data-bs-method="DELETE"><x-bi-trash-fill /></button>
                                @endcan
                                <img src="{{ Storage::url($image->filename) }}" class="d-block w-100" width="640"
                                    height="480">
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <p class="top-50">No Images found :(</p>
            @endif
        </section>
    </div>
    <hr />

    @auth
        <h2>Add A Comment</h2>
        <form method="post" action="{{ route('comment.create', ['hack' => $hack]) }}">
            @csrf
            <textarea class="form-control mb-2" name="text" rows="5"></textarea>
            <button class="btn btn-primary" type="submit">Post Comment</button>
        </form>
        <hr />
    @endauth

    <section id="comments">
        <h1 class="text-decoration-underline" id="comments">Comments</h1>
        @if ($hack->comments->count() > 0)
            @foreach ($hack->comments->sortByDesc('created_at') as $comment)
                <x-romhack-comment :comment="$comment" />
            @endforeach
        @else
            <p>There are no comments for this hack. Be the first one to leave one :) (must be logged in for
                this)</p>
        @endif
    </section>
</x-layout>
