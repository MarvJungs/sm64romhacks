<x-layout>
    <div class="d-flex flex-column">
        @foreach ($actions as $action)
            @if (Auth::check() && Auth::user()->role_id <= $action['role_id'])
                <a class="btn btn-primary mb-4" href="{{ $action['link'] }}">{{ $action['name'] }}</a>
            @endif
        @endforeach
    </div>
</x-layout>
