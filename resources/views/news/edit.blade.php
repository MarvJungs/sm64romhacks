    <x-layout>
        <h1 class="mb-4">Create New News</h1>
        <form id="newsForm" action={{ route('news.update', ['news' => $news]) }} method="post">
            @csrf
            @method('PATCH')
            <div class="row mb-2">
                <div class="col">
                    <label class="form-label" for="title">Title *</label>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col">
                    <input class="form-control" type="text" name="title" id="title" value="{{ $news->title }}"
                        required>
                </div>
            </div>
            <div class="form check mb-4">
                <label class="form-check-label pe-2" for="important">
                    Important
                </label>
                <input class="form-check-input" type="checkbox" name="important" id="important"
                    @checked($news->important)>
            </div>
            <div class="row mb-2">
                <div class="col">
                    <label for="text">Text *</label>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col">
                    <div id="editor-text"></div>
                </div>
            </div>

            <div class="row justify-content-end mb-4">
                <button class="btn btn-primary" type="submit">Send News</button>
            </div>

            <input type="hidden" name="text" id="text" value="{{ $news->text }}">
        </form>
    </x-layout>
