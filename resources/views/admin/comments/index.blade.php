<x-layout>
    @foreach ($comments as $comment)
        <x-romhack-comment :comment="$comment" />
    @endforeach

    {{ $comments->links() }}
</x-layout>