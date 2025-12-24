<x-layout>
    <form method="POST">
        @csrf
        @method('PUT')

        <div class="row mb-3">
            <div class="col">
                <label for="oldName">Old Tagname</label>
                <input name="oldName" type="text" class="form-control" value="{{ $tag->name }}" readonly>
            </div>
            <div class="col">
                <label for="newName">New Tagname</label>
                <input name="newName" type="text" class="form-control" value="{{ old('newName') ?? '' }}">
            </div>
        </div>

        <div class="row">
            <div class="col">
                <button class="btn btn-primary" type="Submit">Update Tag</button>
            </div>
        </div>
    </form>
</x-layout>