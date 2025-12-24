<x-layout>
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="text-decoration-underlined">Recent News</h1>
        @can('create', \App\Models\Newspost::class)
            <a class="btn btn-success" href="{{ route('newspost.create') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Add New Newspost"><x-bi-plus-circle /></a>
        @endcan
    </div>

    @foreach ($newsposts as $newspost)
        <x-newspost :newspost="$newspost" />
    @endforeach
</x-layout>
