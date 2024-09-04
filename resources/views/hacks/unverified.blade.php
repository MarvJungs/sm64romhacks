<x-layout>
    <table class="table table-bordered table-hover">
        <thead>
            <th>Hackname</th>
            <th>Creators</th>
            <th>Initial Release Date</th>
            <th>Starcount</th>
            <th>Submitted At</th>
            <th>Actions</th>
        </thead>
        <tbody>
            @foreach ($hacks as $hack)
                <tr>
                    <td>
                        <a href="{{ route('hacks.show', $hack) }}">
                            {{ $hack->name }}
                        </a>
                    </td>
                    <td>{!! $hack->getAuthorList() !!}</td>
                    <td>{{ $hack->getReleaseDate() }}</td>
                    <td>{{ $hack->getStarcount() }}</td>
                    <td>
                        <span class="time">
                            {{ $hack->created_at }}
                        </span>
                    </td>
                    <td class="d-flex">

                        <form action="/hacks" method="post">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="hack_id" value="{{ $hack->id }}">
                            <button class="btn btn-success m-2" type="submit">
                                <span class="fa-regular fa-circle-check"></span>
                            </button>
                        </form>

                        <form action="/hacks" method="post">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="hack_id" value="{{ $hack->id }}">
                            <button class="btn btn-danger m-2" type="submit">
                                <span class="fa-regular fa-xmark"></span>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-layout>
