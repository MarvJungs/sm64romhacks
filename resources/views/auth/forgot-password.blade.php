<x-layout>
    <form method="post">
        @csrf
        <div class="row mb-3">
            <label for="email" class="col-sm-2 col-form-label">Email</label>
            <div class="col-sm-10">
                <input name="email" type="email" class="form-control" />
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Reset Password</button>
    </form>
</x-layout>