<div class="bg-body-tertiary rounded mb-4">
    <form method="post">
        @csrf
        <div class="p-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="5" >{{$user->description}}</textarea>
            @error('description')
                <span class="text-danger mt-1">{{ $message }}</span>
            @enderror
        </div>
        <div class="p-3">
            <button class="btn btn-secondary" type="submit">Save Description</button>
        </div>
    </form>
</div>

<div class="bg-body-tertiary rounded mb-4">
    <form method="post" enctype="multipart/form-data">
        @csrf
        <div class="p-3">
            <label for="avatar" class="form-label">Profile Picture</label>
            <input name="avatar" type="file" class="form-control" >
            @error('avatar')
                <span class="text-danger mt-1">{{ $message }}</span>
            @enderror
        </div>
        <div class="p-3">
            <button class="btn btn-secondary" type="submit">Save Avatar</button>
        </div>
    </form>
</div>

<div class="bg-body-tertiary rounded mb-4">
    <form method="post">
        @csrf
        <div class="p-3">
            <label for="country_id" class="form-label">Location</label>
            <select name="country_id" class="form-select @error('country_id') is-invalid @enderror">
                <option value="">Select A Country</option>
                @foreach ($countries as $country)
                    @if ($user->country?->id === $country->id)
                        <option value="{{ $country->id }}" selected>{{ $country->emoji }} {{ $country->name }}</option>
                    @else
                        <option value="{{ $country->id }}">{{ $country->emoji }} {{ $country->name }}</option>
                    @endif
                @endforeach
            </select>
            @error('country_id')
                <span class="text-danger mt-1">{{ $message }}</span>
            @enderror
        </div>
        <div class="p-3">
            <button class="btn btn-secondary" type="submit">Save Location</button>
        </div>
    </form>
</div>
