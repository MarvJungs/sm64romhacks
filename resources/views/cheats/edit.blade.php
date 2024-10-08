<x-layout>
    <form action="{{ route('cheats.update', ['cheat' => $cheat]) }}" method="POST" id="cheatForm">
        @csrf
        <div class="row mb-4">
            <div class="col">
                <label for="title">Display Name</label>
                <input class="form-control" name="title" id="title" value="{{ $cheat->title }}" required>
                <input type="hidden" name="description" id="description" value="{{ $cheat->description }}">
                <input type="hidden" name="code" id="code">
            </div>
        </div>
        <div class="row mb-4">
            <div class="col">
                <label class="mb-2" for="editor-description">
                    Description <span class="fa-solid fa-info btn btn-primary rounded-pill ms-2"
                        data-bs-toggle="tooltip"
                        data-bs-title="Type '/' in the editor box to call the context menu!"></span>
                </label>
                <div id="editor-description"></div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col">
                <label for="code">Cheat Code</label>
                <textarea name="code" class="form-control" id="code" cols="15" rows="10">
                    {{ $cheat->code }}
                </textarea>
            </div>
        </div>
        <div class="d-flex justify-content-center">
            <div class="row w-25">
                <div class="col">
                    <button class="form-control btn btn-primary" type="submit">Add Cheat
                        Code</button>
                </div>
            </div>
        </div>
        </div>
    </form>
</x-layout>
