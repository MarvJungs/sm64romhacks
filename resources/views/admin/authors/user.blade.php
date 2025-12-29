<x-layout>
    <form method="post">
        @csrf
        <div class="row mb-3">
            <div class="col">
                <label for="authorName" class="form-label">Authorname</label>
                <input class="form-control @error('authorName') is-invalid @enderror" name="authorName" type="text" value="{{ $author->name }}" readonly />
                @error('authorName')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="col">
                <div class="d-flex justify-content-center align-items-center">
                    <x-bi-arrow-right height="64" width="64"/>
                </div>
            </div>
            <div class="col">
                <label for="user_id" class="form-label">Username</label>
                <select class="form-select" name="user_id">
                    <option value="">Please Select A User</option>
                    @foreach ($users as $user)
                        @if ($user->id === $author->user_id)
                            <option value="{{ $user->id }}" selected>{{ $user->name }}</option>
                        @else
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endif
                    @endforeach
                </select>
                @error('user_id')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <button class="btn btn-primary" type="submit">Update Author!</button>
    </form>
</x-layout>