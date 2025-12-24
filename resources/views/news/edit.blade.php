<x-layout>
    <h1>Create a Newspost</h1>
    <p>Here you can edit a Newspost!</p>

    <form method="post" id="createNewspost">
        @method('PUT')
        <div class="mb-3">
            <label class="form-label" for="title">Title</label>
            @error('title')
                <p class="text-danger mt-1">{{ $message }}</p>
            @enderror
            <input class="form-control @error('title') is-invalid @enderror" name="title" type="text" value="{{$newspost->title?? old('title')}}" />
            <p class="form-text">This is the title of the newspost.</p>
        </div>

        <div class="mb-3">
            <label class="form-label" for="text">Text</label>
            <p class="form-text">This is the text displayed on the post</p>
            @error('text')
                <p class="text-danger mt-1">{{ $message }}</p>
            @enderror
            @error('text.blocks')
                <p class="text-danger mt-1">{{ $message }}</p>
            @enderror
            <div name="text" class="form-control" id="newsEditor">
                @csrf
            </div>
        </div>

        <input type="hidden" name="text" id="text" value="{{json_encode($newspost->text ?? old('text'))}}" />
        <button class="btn btn-primary" type="button" id="newsSubmitButton">Save Newspost</button>
    </form>
</x-layout>
