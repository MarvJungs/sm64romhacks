<x-layout>
    <div class="d-flex justify-content-between align-items-center">
        <h1>Cheatcodes</h1>
        @can('create', \App\Models\Cheatcode::class)
            <a class="btn btn-success" href="{{ route('admin.cheats.create') }}" data-bs-toggle="tooltip"
                data-bs-placement="top" data-bs-title="Add new Cheatcode"><x-bi-plus /></a>
        @endcan
    </div>
    <section id="table-of-contents">
        <h2>Table of Contents</h2>
        <ol>
            @foreach ($cheatcodes as $cheatcode)
                <li><a
                        href="{{ Uri::of(route('cheats.index'))->withFragment(Str::slug($cheatcode->name)) }}">{{ $cheatcode->name }}</a>
                </li>
            @endforeach
        </ol>
    </section>
    <hr />
    <section id="cheatcodes">
        @foreach ($cheatcodes as $cheatcode)
            <div id="{{ Str::slug($cheatcode->name) }}">
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="text-decoration-underline">{{ $cheatcode->name }}</h2>
                    <div>
                        <button name="{{ Str::slug($cheatcode->name) }}" class="btn btn-primary"
                            data-bs-toggle="tooltip" data-bs-placement="top"
                            data-bs-title="Copy Cheatcode"><x-bi-clipboard /></button>
                        @can('update', $cheatcode)
                            <a class="btn btn-secondary"
                                href="{{ route('admin.cheats.edit', ['cheatcode' => $cheatcode]) }}"
                                data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-title="Edit Cheatcode"><x-bi-pencil /></a>
                        @endcan
                        @can('delete', $cheatcode)
                            <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete Cheatcode">
                                <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modal-confirm"
                                    data-bs-route="{{ route('admin.cheats.destroy', ['cheatcode' => $cheatcode]) }}"
                                    data-bs-method="DELETE"><x-bi-trash /></button>
                            </span>
                        @endcan
                    </div>
                </div>
                @if (!is_null($cheatcode->description))
                    <section class="alert alert-info" role="alert">
                        <div class="line-break">
                            {{ $cheatcode->description }}
                        </div>
                    </section>
                @endif
                <code class="line-break">{{ $cheatcode->code }}</code>
            </div>
            <hr />
        @endforeach
    </section>
</x-layout>
