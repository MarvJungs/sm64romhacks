<table class="table table-bordered table-hover">
    <x-table.users.head />
    @foreach ($users as $user)
        <tbody>
            <x-table.users.row :user="$user" :roles="$roles" />
        </tbody>
    @endforeach
</table>