<x-layout>
    <form action="{{ route('cheats.update', ['cheat' => $cheat]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row mb-4">
            <div class="col">
                <label for="display_name">Display Name</label>
                <input class="form-control" name="display_name" id="display_name" value="{{$cheat->display_name}}" required>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col">
                <label for="description">Description</label>
                <textarea class="form-control" name="description" id="description" rows="5">{{$cheat->description}}</textarea>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col">
                <label for="code">Cheat Code</label>
                <textarea class="form-control" name="code" id="code" rows="10" cols="15" required>{{$cheat->code}}</textarea>
            </div>
        </div>
        <div class="d-flex justify-content-center">
            <div class="row w-25">
                <div class="col">
                    <button class="form-control btn btn-primary" type="submit">Save Cheat Code</button>
                </div>
            </div>
        </div>
    </form>
</x-layout>
