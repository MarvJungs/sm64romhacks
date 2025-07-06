<x-layout>
    <div class="card mb-5">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h4>{{ $newspost->title }}</h4>
                <div>
                    <a class="btn btn-primary me-2 text-decoration-none" href="/news/{{ $newspost->id }}"><img
                            class="me-2" src="/icons/view.svg" />View Newspost</a>
                    <a class="btn btn-info me-2 text-decoration-none"
                        href="/moderation/newsposts/{{ $newspost->id }}/edit"><img class="me-2" src="/icons/edit.svg" />Edit
                        Newspost</a>
                    <a class="btn btn-danger me-2 text-decoration-none"
                        href="/moderation/newsposts/{{ $newspost->id }}/delete"><img class="me-2"
                            src="/icons/delete.svg" />Delete Newspost</a>
                </div>
            </div>
            <p class="text-info">Written by <img src="/storage/{{ $newspost->user->avatar }}" height="32"
                    width="32" /> <a href="">{{ $newspost->user->name }}</a> at <span
                    class="time">{{ $newspost->created_at }}</span> (last
                updated at <span class="time">{{ $newspost->updated_at }}</span>)</p>
        </div>
        <div class="card-body">
            <div class="card-text">
                <x-editor-js :blocks="$newspost->text['blocks']" />
            </div>
        </div>
    </div>
</x-layout>
