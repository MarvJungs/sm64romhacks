<x-layout>
    <form method="post">
        @csrf
        <input type="hidden" name="token" value="{{$token}}" />
        <div class="row mb-3">
            <label for="email" class="col-sm-2 col-form-label">Email</label>
            <div class="col-sm-10">
                <input name="email" type="email" class="form-control" value="{{request()->query('email')}}" />
            </div>
        </div>
        <div class="row mb-3">
            <label for="password" class="col-sm-2 col-form-label">Password</label>
            <div class="col-sm-10">
                <input name="password" type="password" class="form-control" />
            </div>
        </div>
        <div class="row mb-3">
            <label for="password_confirm" class="col-sm-2 col-form-label">Password Confirmation</label>
            <div class="col-sm-10">
                <input name="password_confirmation" type="password" class="form-control" />
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Reset Password</button>
    </form>
</x-layout>