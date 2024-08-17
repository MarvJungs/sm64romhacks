<x-layout>
    <form action="{{ route('cheats.update', ['cheat' => $cheat]) }}" method="POST" id="cheatForm">
        @csrf
        <div class="row mb-4">
            <div class="col">
                <label for="title">Display Name</label>
                <input class="form-control" name="title" id="title" required>
                <input type="hidden" name="description" id="description" value="{{ $cheat->description }}">
                <input type="hidden" name="code" id="code">
            </div>
        </div>
        <div class="row mb-4">
            <div class="col">
                <label class="mb-3" for="description">Description</label>
                <div id="editor-description"></div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col">
                <label for="code">Cheat Code</label>
                <textarea name="code" class="form-control" id="code" cols="15" rows="10"></textarea>
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
