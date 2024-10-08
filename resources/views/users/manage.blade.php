<x-layout>
    <h1>Assign Authors to Users</h1>
    <form action="/authors" method="post">
        @csrf
        @method('PATCH')
        <div class="row mb-4">
            <div class="col">
                <select class="form-select" name="user_id" id="user_id">
                    @foreach ($allUsers as $user)
                        <option value="{{ $user->id }}">{{ $user->global_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col d-flex justify-content-center align-items-center">
                <span class="fa-solid fa-arrow-right fa-3x"></span>
            </div>
            <div class="col">
                <select class="form-select" name="author_id" id="author_id">
                    @foreach ($allAuthors as $author)
                        <option value="{{ $author->id }}">{{ $author->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row w-100">
            <button class="form-control btn btn-primary" type="submit">Save Changes</button>
        </div>
    </form>
</x-layout>
