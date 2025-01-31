<x-layout>
    <form action="{{route('races.results', ['event' => $event])}}" class="row g-3" method="POST">
        @csrf
        @foreach ($raceParticipants as $raceParticipant)
            <div class="row mb-3">
                <div class="col-auto">
                    <label for="runner[]" class="form-label">Runner</label>
                    <select name="runner[]" class="form-select">
                        <option value="">Please Select A Runner</option>
                        @foreach ($raceParticipants as $raceParticipant)
                            <option value="{{$raceParticipant->user->id}}">{{ $raceParticipant->user->global_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-auto">
                    <label for="sr1Time[]" class="form-label">SR1 66 Star Time</label>
                    <input type="text" name="sr1Time[]" class="form-control" minlength="1" size="8" maxlength="8" required>
                </div>
                <div class="col-auto">
                    <label for="sr2Time[]" class="form-label">SR2 TTM 41 Star Time</label>
                    <input type="text" name="sr2Time[]" class="form-control" minlength="1" size="8" maxlength="8" required>
                </div>
                <div class="col-auto">
                    <label for="sr3Time[]" class="form-label">SR3 36 Star Time </label>
                    <input type="text" name="sr3Time[]" class="form-control" minlength="1" size="8" maxlength="8" required>
                </div>
                <div class="col-auto">
                    <label for="sr4Time[]" class="form-label">SR4.5 50 Star Time</label>
                    <input type="text" name="sr4Time[]" class="form-control" minlength="1" size="8" maxlength="8" required>
                </div>
                <div class="col-auto">
                    <label for="sr5Time[]" class="form-label">SR5 31 Star Time</label>
                    <input type="text" name="sr5Time[]" class="form-control" minlength="1" size="8" maxlength="8" required>
                </div>
                <div class="col-auto">
                    <label for="sr6Time[]" class="form-label">SR6 50 Star Time</label>
                    <input type="text" name="sr6Time[]" class="form-control" minlength="1" size="8" maxlength="8" required>
                </div>
                <div class="col-auto">
                    <label for="sr7Time[]" class="form-label">SR7 61 Star Time</label>
                    <input type="text" name="sr7Time[]" class="form-control" minlength="1" size="8" maxlength="8" required>
                </div>
                <div class="col-auto">
                    <label for="sr8Time[]" class="form-label">SR8 80 Star Time</label>
                    <input type="text" name="sr8Time[]" class="form-control" minlength="1" size="8" maxlength="8" required>
                </div>
            </div>
            <div class="row">
                <div class="col-auto">
                    <label for="totalStars[]" class="form-label">Total Stars</label>
                    <input type="number" name="totalStars[]" class="form-control" minlength="1" maxlength="3" size="3">
                </div>
            </div>
            <hr />
        @endforeach
        <button type="submit" class="btn btn-primary">Set Results!</button>
    </form>
</x-layout>
