<x-layout>
    <section id="news" class="mb-4">
        <h1>Latest News</h1>
        @if (sizeof($news) > 0)
            @foreach ($news as $message)
                <x-cards.news :message="$message" />
            @endforeach
        @else
            <em>No News found</em>
        @endif
    </section>
    <section id="versions" class="mb-4">
        <h1>Latest Added Versions</h1>
        <x-table.versions.table :versions="$versions" />
    </section>
    <section id="comments" class="mb-4">
        <h1>Latest Comments Added</h1>
        @if (sizeof($comments) > 0)
            @foreach ($comments as $comment)
                <x-cards.user-comment :comment="$comment" />
            @endforeach
        @else
            <em>No Comments found</em>
        @endif
    </section>
</x-layout>
