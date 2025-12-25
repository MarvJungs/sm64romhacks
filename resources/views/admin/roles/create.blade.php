<x-layout>
    <form method="post">
        @csrf
        <div class="row mb-3">
            <div class="col">
                <label for="name" class="form-label">Rolename</label>
                <input class="form-control @error('name') is-invalid @enderror" name="name" type="text" value="{{ old('name') }}" />
                @error('name')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="col">
                <label for="priority" class="form-label">Priority</label>
                <input class="form-control @error('priority') is-invalid @enderror" name="priority" type="number" value="{{ old('priority') }}" />
                @error('priority')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <button class="btn btn-primary" type="submit">Create Role!</button>
    </form>
</x-layout>