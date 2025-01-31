<x-layout>
    <form action={{route("races.register", ['event' => $event])}} method="POST">
        @csrf
        <div class="row mb-3">
            <label for="name" class="col-sm col-form-label">Name</label>
            <div class="col-sm-10">
                <input type="text" class="form-control-plaintext" name="signupName"
                    value="{{ Auth::user()->global_name }}" required readonly>
            </div>
        </div>
        <div class="row mb-3">
            <label for="sr1Time" class="col-sm col-form-label">What is your SR1.5 66 Star PB?</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="sr1Time" minlength="8" maxlength="8" size="8" value="02:30:00" required>
            </div>
        </div>
        <div class="row mb-3">
            <label for="sr2Time" class="col-sm col-form-label">What is your SR2 TTM 41 Star PB?</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="sr2Time" minlength="8" maxlength="8" size="8" value="02:00:00"
                    required>
            </div>
        </div>
        <div class="row mb-3">
            <label for="sr3Time" class="col-sm col-form-label">What is your SR3 36 Star PB?</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="sr3Time" minlength="8" maxlength="8" size="8" value="01:00:00"
                    required>
            </div>
        </div>
        <div class="row mb-3">
            <label for="sr4Time" class="col-sm col-form-label">What is your SR4.5 50 Star PB?</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="sr4Time" minlength="8" maxlength="8" size="8" value="02:00:00"
                    required>
            </div>
        </div>
        <div class="row mb-3">
            <label for="sr5Time" class="col-sm col-form-label">What is your SR5 31 Star PB?</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="sr5Time" minlength="8" maxlength="8" size="8" value="01:00:00"
                    required>
            </div>
        </div>
        <div class="row mb-3">
            <label for="sr6Time" class="col-sm col-form-label">What is your SR6 50 Star PB?</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="sr6Time" minlength="8" maxlength="8" size="8" value="02:00:00"
                    required>
            </div>
        </div>
        <div class="row mb-3">
            <label for="sr7Time" class="col-sm col-form-label">What is your SR7 61 Star PB?</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="sr7Time" minlength="8" maxlength="8" size="8" value="02:30:00"
                    required>
            </div>
        </div>
        <div class="row mb-3">
            <label for="sr8Time" class="col-sm col-form-label">What is your SR8 80 Star PB?</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="sr8Time" minlength="8" maxlength="8" size="8" value="03:00:00"
                    required>
            </div>
        </div>
        <div class="form-check bg-info-subtle mb-3">
            <input class="form-check-input" type="checkbox" value="" id="checkReadRules" name="checkReadRules" required>
            <label class="form-check-label" for="checkReadRules">
                I read and accept the race rules that are noted on the corresponding
                webpage. Make sure you have a Twitch account ready for streaming the race and make sure you are
                signed up for therun.gg for taking part of the race! If you are not in the race room after the
                planned race start and everyone who is in the room is ready, then we will start without you if
                contacting you doesn't result in any reaction. Then you will be listed as DNS (Did Not Show) on
                the stats.
            </label>
        </div>
        <div class="col">
            <button type="submit" class="btn btn-primary">Sign in</button>
        </div>
    </form>
</x-layout>
