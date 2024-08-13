<x-layout>
    <form action="{{ route('cheats.store') }}" method="POST" id="createCheat">
        @csrf
        <div class="row mb-4">
            <div class="col">
                <label for="title">Display Name</label>
                <input class="form-control" name="title" id="title" required>
                <input type="hidden" name="description" id="description">
                <input type="hidden" name="code" id="code">
            </div>
        </div>
        <div class="row mb-4">
            <div class="col">
                <div class="card">
                    <div class="card-header">Description</div>
                    <div class="card-body over-hidden">
                        <div class="card-text">
                            <div id="editor-description" class="p-3"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col">
                <div class="card">
                    <div class="card-header">Cheat Code</div>
                    <div class="card-body over-hidden">
                        <div class="card-text">
                            <div id="editor-cheat" class="p-3"></div>
                        </div>
                    </div>
                </div>
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
