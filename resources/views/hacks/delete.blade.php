<x-layout>
    <div class="alert alert-primary" role="alert">
        <form method="post">
            @csrf
            @method('DELETE')
            <p>
                Are you sure you want to delete the Hack &quot;{{ $hack->name }}&quot; ? This action is permanent and
                cannot be undone.
            </p>
            <div class="d-flex justify-content-between">
                <a class="btn btn-info" href="/back">Return</a>
                <button class="btn btn-danger" type="submit">Delete</button>
            </div>
        </form>
    </div>
</x-layout>