<x-layout>
    <div class="row">
        {{-- <div class="col-md-auto">
            <x-auth.settings.sidebar />
        </div> --}}
        <div class="col">
            <x-dynamic-component :component="$section" :countries="$countries" :user="$user" />
        </div>
    </div>
</x-layout>
