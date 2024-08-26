@php
    function getAuthorsList($hack)
    {
        $versions = $hack->versions()->orderBy('releasedate', 'asc')->get();
        $firstVersion = $versions->first();
        if ($firstVersion) {
            $authors = $firstVersion->authors;
            $authorsList = '';
            foreach ($authors as $author) {
                if ($author->user) {
                    $authorsList .= '<a href="/users/' . $author->user->id . '">' . $author->name . '</a>, ';
                } else {
                    $authorsList .= $author->name . ', ';
                }
            }
            $authorsList = substr($authorsList, 0, strlen($authorsList) - 2);
        } else {
            $authorsList = 'unknown';
        }
        return $authorsList;
    }
@endphp

<x-layout>
    <h1 class="text-center">Grand ROM Hack Megapack</h1>
    <p>
        This megapack offers a selection of major Super Mario 64 ROM Hacks which are universally considered to be the
        greatest. This is in hope to provide an ideal starter pack which serves as an easily accessible introduction to
        the world of ROM Hacks.
    </p>
    <p>
        <em>Contents of this page were last updated: <span
                class='time'>{{ date('Y-m-d H:i:s', Storage::lastModified('megapack/Grand Rom Hack Megapack 2024 (Summer Edition).zip')) }}</span></em>
    </p>
    <div class="btn-group-lg megapackButtons" role="group">
        <a class="btn btn-primary" href="/megapack/download?type=normal">Download Megapack</a>
        <a class="btn btn-danger" href="/megapack/download?type=kaizo">Download KAIZO Megapack</a>
    </div>

    <div class="d-flex justify-content-center">
        <select class="form-select mt-4 w-25 mb-3" id="difficultyFilter">
            <option selected value="">Select A Difficulty Level To Filter</option>
            @foreach ($megapack as $difficulty => $collection)
                <option value="{{ $difficulty }}">{{ Str::ucfirst($difficulty) }}</option>
            @endforeach
        </select>
    </div>

    <div id="normalHacks">
        <h1 class="text-center">Normal Megapack Hacks</h1>
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th scope="col">
                        Hackname
                    </th>
                    <th scope="col">
                        Creator
                    </th>
                    <th scope="col">
                        Starcount
                    </th>
                    <th scope="col" class="text-nowrap">
                        Release Date
                    </th>
                    <th scope="col">
                        Difficulty
                    </th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                @foreach (Arr::except($megapack, 'kaizo') as $difficulty => $collection)
                    @foreach ($megapack[$difficulty] as $hack)
                        <tr>
                            <td>
                                <a href="/hacks/{{ $hack->id }}">{{ $hack->name }}</a>
                            </td>
                            <td>
                                {!! getAuthorsList($hack) !!}
                            </td>
                            <td>
                                {{ $hack->versions()->max('starcount') }}
                            </td>
                            <td>
                                {{ $hack->versions()->orderBy('releasedate', 'asc')->pluck('releasedate')->first() }}
                            </td>
                            <td>
                                {{ Str::ucfirst($difficulty) }}
                            </td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>


    <div id="kaizoHacks">
        <h1 class="text-center">Kaizo Megapack Hacks</h1>
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th scope="col">
                        Hackname
                    </th>
                    <th scope="col">
                        Creator
                    </th>
                    <th scope="col">
                        Starcount
                    </th>
                    <th scope="col" class="text-nowrap">
                        Release Date
                    </th>
                    <th scope="col">
                        Difficulty
                    </th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                @foreach ($megapack['kaizo'] as $hack)
                    <tr>
                        <td>
                            <a href="/hacks/{{ $hack->id }}">{{ $hack->name }}</a>
                        </td>
                        <td>
                            {!! getAuthorsList($hack) !!}
                        </td>
                        <td>
                            {{ $hack->versions()->max('starcount') }}
                        </td>
                        <td>
                            {{ $hack->versions()->orderBy('releasedate', 'asc')->pluck('releasedate')->first() }}
                        </td>
                        <td>
                            Kaizo
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-layout>
