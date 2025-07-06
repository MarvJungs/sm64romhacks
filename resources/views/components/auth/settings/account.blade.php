<div class="bg-body-tertiary rounded mb-4">
    <form method="post">
        @csrf
        <div class="p-3">
            <label for="name" class="form-label">Username</label>
            <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" value="{{Auth::user()->name}}" />
            @error('name')
                <span class="text-danger mt-1">{{ $message }}</span>
            @enderror
        </div>
        <div class="p-3">
            <button class="btn btn-secondary" type="submit">Save Username</button>
        </div>
    </form>
</div>


<div class="bg-body-tertiary rounded mb-4">
    <form method="post">
        @csrf
        <div class="p-3">
            <label for="email" class="form-label">Email-Address</label>
            <input name="email" type="email" class="form-control @error('email') is-invalid @enderror" value="{{Auth::user()->email}}" />
            @error('email')
                <span class="text-danger mt-1">{{ $message }}</span>
            @enderror
        </div>
        <div class="p-3">
            <label for="email" class="form-label">Confirm Email-Address</label>
            <input name="email_confirmation" type="email"
                class="form-control @error('email_confirmation') is-invalid @enderror" />
            @error('email_confirmation')
                <span class="text-danger mt-1">{{ $message }}</span>
            @enderror
        </div>
        <div class="p-3">
            <button class="btn btn-secondary" type="submit">Save Email-Address</button>
        </div>
    </form>
</div>

<div class="bg-body-tertiary rounded mb-4">
    <form method="post">
        @csrf
        <div class="p-3">
            <label for="password" class="form-label">Password</label>
            <input name="password" type="password" class="form-control @error('password') is-invalid @enderror" />
            @error('password')
                <span class="text-danger mt-1">{{ $message }}</span>
            @enderror
        </div>
        <div class="p-3">
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <input name="password_confirmation" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" />
            @error('password_confirmation')
                <span class="text-danger mt-1">{{ $message }}</span>
            @enderror
        </div>
        <div class="p-3">
            <button class="btn btn-secondary" type="submit">Save Password</button>
        </div>
    </form>
</div>

<div class="bg-body-tertiary rounded mb-4">
    <form method="post">
        @csrf
        <div class="p-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="5" >{{Auth::user()->description}}</textarea>
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
                    @if (Auth::user()->country?->id === $country->id)
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
