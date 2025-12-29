<x-layout>
    <form method="post">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" />
            @error('name')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="10">{{ old('description') }}</textarea>
            @error('description')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-3">
            <label for="code" class="form-label">Cheat Code</label>
            <textarea class="form-control @error('code') is-invalid @enderror" name="code" rows="10">{{ old('code') }}</textarea>
            @error('code')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>

        <div class="col-12">
            <button type="submit" class="btn btn-primary">Add Cheatcode!</button>
        </div>
        
    </form>
</x-layout>
