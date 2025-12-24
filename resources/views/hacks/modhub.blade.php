<x-layout>
    <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="hacks-tab" data-bs-toggle="tab" data-bs-target="#hacks" type="button" role="tab"
                aria-controls="hacks" aria-selected="true">Hacks</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="authors-tab" data-bs-toggle="tab" data-bs-target="#authors" type="button" role="tab"
                aria-controls="authors" aria-selected="true">Authors</button>
        </li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane fade show active" id="hacks" role="tabpanel" aria-labelledby="hacks-tab" tabindex="0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Romhack Name</th>
                            <th>Authors</th>
                            <th>Release Date</th>
                            <th>Starcount</th>
                            <th>Tags</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($hacks as $hack)
                            <tr>
                                <td><a href="{{ route('hack.show', ['hack' => $hack]) }}">{{ $hack->name }}</a></td>
                                <td>{{ $hack->versions->flatMap->authors->pluck('name')->unique()->join(', ') }}</td>
                                <td>{{ $hack->versions->min('releasedate') }}</td>
                                <td>{{ $hack->versions->max('starcount') }}</td>
                                <td>{{ $hack->romhacktags->pluck('name')->join(', ') }}</td>
                                <td>
                                    <form class="d-inline" method="post"
                                        action="{{ route('modhub.hacks.verify', ['hack' => $hack]) }}">
                                        @csrf
                                        <button class="btn btn-success" type="submit">
                                            <x-bi-check-square-fill />
                                        </button>
                                    </form>
                                    <form class="d-inline" method="post"
                                        action="{{ route('modhub.hacks.reject', ['hack' => $hack]) }}">
                                        @csrf
                                        <button class="btn btn-danger" type="submit">
                                            <x-bi-x-circle />
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="tab-pane fade" id="authors" role="tabpanel" aria-labelledby="authors-tab" tabindex="0">
            TBD
        </div>
    </div>
</x-layout>
