<x-layout>
    <form action="/profile" method="post">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control mb-4 w-auto"
                    @disabled(true) value="{{ $user->display_name }}">
            </div>
            <div class="col">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" @disabled(true)
                    class="form-control mb-4 w-auto" value="{{ $user->email }}">
            </div>
        </div>

        <div class="row">
            <div class="col">
                <label for="gender">Gender</label>
                <input type="text" name="gender" id="gender" class="form-control mb-4 w-auto"
                    value="{{ $user->gender }}">
            </div>
            <div class="col">
                <label for="country">Country</label>
                <select name="country" id="country" class="form-select mb-4 w-auto">
                    <option value=""></option>
                    @foreach ($countries as $country)
                        <option value="{{ $country['iso2'] }}" @selected($user->country == $country['iso2'])>{{ $country['name'] }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <button class="form-control btn btn-primary" type="submit">Save Changes!</button>
    </form>
</x-layout>
