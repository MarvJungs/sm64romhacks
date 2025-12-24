<x-layout>
    <form method="post">
        @csrf
        @method('PUT')
        <div class="row mb-3">
            <div class="col">
                <label for="oldName" class="form-label">Old Authorname</label>
                <input class="form-control @error('oldName') is-invalid @enderror" name="oldName" type="text" value="{{ $role->name }}" readonly />
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
                <input class="form-control @error('newName') is-invalid @enderror" name="newName" type="text" value="{{ old('newName') ?? $role->name }}"/>
                @error('newName')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <div class="col">
                <label for="oldPriority" class="form-label">Old Priority</label>
                <input class="form-control @error('oldPriority') is-invalid @enderror" name="oldPriority" type="number" value="{{ $role->priority }}" readonly />
                @error('oldPriority')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="col">
                <div class="d-flex justify-content-center align-items-center">
                    <x-bi-arrow-right height="64" width="64"/>
                </div>
            </div>
            <div class="col">
                <label for="newPriority" class="form-label">New Priority</label>
                <input class="form-control @error('newPriority') is-invalid @enderror" name="newPriority" type="number" value="{{ old('newPriority') ?? $role->priority }}"/>
                @error('newPriority')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <button class="btn btn-primary" type="submit">Update Role!</button>
    </form>
</x-layout>