<x-layout>
    <form method="post">
        @csrf
        @method('PUT')
        <div class="row mb-3">
            <div class="col">
                <label for="oldName" class="form-label">Old Authorname</label>
                <input class="form-control @error('oldName') is-invalid @enderror" name="oldName" type="text" value="{{ $author->name }}" readonly />
                @error('oldName')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="col">
                <div class="d-flex justify-content-center align-items-center">
                    <x-bi-arrow-right height="64" width="64"/>
                </div>
            </div>
            <div class="col">
                <label for="newName" class="form-label">New Authorname</label>
                <input class="form-control @error('newName') is-invalid @enderror" name="newName" type="text" value="{{ old('newName') ?? $author->name }}"/>
                @error('newName')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <button class="btn btn-primary" type="submit">Update Author!</button>
    </form>
</x-layout>