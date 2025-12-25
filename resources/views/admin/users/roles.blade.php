<x-layout>
    <form id="manageRoles" method="post">
        @csrf
        <div class="row mb-3">
            <div class="col-auto">
                <div>
                    <label for="roles" class="form-label">Roles of the User &quot;{{ $user->name }}&quot;</label>
                </div>
                <div>
                    <div class="mb-1"></div>
                    <select id="roles" class="form-select">
                        <option value="">Please Select A Role</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">Save Roles</button>
            </div>
        </div>
    </form>

    @foreach ($user->roles as $role)
        <input name="roles[]" type="hidden" value="{{ $role->name }}" />
    @endforeach
</x-layout>
