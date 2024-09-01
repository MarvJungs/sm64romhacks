<table class="table table-bordered table-hover">
    <x-table.versions.head />
    <tbody>
        @foreach ($versions as $version)
            <x-table.versions.row :version="$version" />
        @endforeach
    </tbody>
</table>