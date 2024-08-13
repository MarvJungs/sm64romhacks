<x-layout>
    <form action={{route('disruptions.store')}} method="post">
        @csrf
        <label class="form-label" for="event_id">Event</label>
        <select class="form-select mb-4" name="event_id" id="event_id" @required(true)>
            <option value="" @selected(true)>Select an Event</option>
            @foreach ($events as $event)
                <option value="{{$event->id}}">{{$event->name}}</option>
            @endforeach
        </select>
        <label class="form-label" for="text">Disruptions text</label>
        <input class="form-control mb-4" type="text" name="text" id="text" @required(true)>
        <button class="btn btn-primary" type="submit">Add Disruption</button>
    </form>
</x-layout>