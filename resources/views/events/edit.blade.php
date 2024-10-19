<x-layout>
    <h1 class="text-center text-decoration-underline">Event Creation Form</h1>
    <form method="POST" action="{{ route('events.update', ['event' => $event]) }}" id="eventForm">
        @csrf
        @method('PUT')

        <datalist id="hacknames">
            @foreach ($hacks as $hack)
                <option value="{{ $hack->name }}">{{ $hack->name }}</option>
            @endforeach
        </datalist>

        <div class="row mb-4">
            <div class="col">
                <label for="slug">Slug</label>
                <input id="slug" class="form-control" name="slug" value="{{ $event->slug }}" required>
            </div>
            <div class="col">
                <label for="name">Event Title</label>
                <input íd="name" class="form-control" name="name" value="{{ $event->name }}" required>
            </div>
        </div>
        <div class="row gap-3 mb-4">
            <div class="col">
                <label for="start_utc">Start Time (in UTC)</label>
                <input type="datetime-local" id="start_utc" class="form-control w-auto" name="start_utc"
                    value="{{ $event->start_utc }}">
            </div>
            <div class="col">
                <label for="end_utc">End Time (in UTC)</label>
                <input type="datetime-local" id="end_utc" class="form-control w-auto" name="end_utc"
                    value="{{ $event->end_utc }}">
            </div>
            <div class="col">
                <label for="event_type">Event Type</label>
                <select class="form-select" name="event_type" id="event_type">
                    <option @selected(false)>Select An Event Type</option>
                    @foreach ($event_types as $id => $type)
                        <option @selected($event->eventType->type == $type) value="{{ $id }}">{{ $type }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div id="league_settings" hidden>
            <h2>League Settings</h2>
            <p>Here you can set up the League Settings to your liking!</p>
            <div class="row mb-3">
                <label for="points_system" class="col-sm-2 col-form-label">
                    Point System
                </label>
                <div class="col-sm-10">
                    <select name="points_system" id="points_system" class="form-select mb-2">
                        <option value="">Select A Points System</option>
                        @foreach ($points_systems as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <h3>League Categories</h3>
            <div class="row row-cols-5 align-items-start justify-content-between mb-3">
                <div class="col-4">
                    <label for="category_url" class="form-label">
                        Link to speedrun.com Leaderboard
                        <span class="fa-solid fa-info btn btn-primary rounded-pill ms-2" data-bs-toggle="tooltip"
                            data-bs-title="Only enter One Category Link per Input Field. Press on the + for more Input Fields."></span>
                        <button class="btn" id="addCategoryUrl"><span class="fa-solid fa-plus"></span></button>
                    </label>
                </div>
                <div class="col-2">
                    <label for="hack" class="form-label">Hackname</label>
                </div>
                <div class="col-2">
                    <label for="category_name" class="form-label">Category Name</label>
                </div>
                <div class="col-2">
                    <label for="bonus_points" class="form-label">Bonus Points</label>
                </div>
                <div class="col-2">
                    Remove
                </div>
            </div>

            <div class="row row-cols-5 align-items-start justify-content-between mb-3">
                <div class="col-4" id="categoryUrlColumn" name="game_name">
                    @if (!is_null($event->league))
                        @foreach ($event->league->leagueCategories as $index => $leagueCategory)
                            <div class="d-flex justify-content-between" name="searchGameInput">
                                <input type="text" name="searchGameInput[]"
                                    class="form-control mb-3 me-3 searchGameInput"
                                    value="{{ $leagueCategory->hack->name }}" list="hacknames">
                                <button class="btn btn-primary searchGameButton mb-3 fa-solid fa-search"
                                    value={{ $index + 1 }}>
                                </button>
                            </div>
                        @endforeach
                    @else
                        <div class="d-flex justify-content-between" name="searchGameInput">
                            <input type="text" name="searchGameInput[]"
                                class="form-control mb-3 me-3 searchGameInput" list="hacknames">
                            <button class="btn btn-primary searchGameButton mb-3 fa-solid fa-search" value="1">
                            </button>
                        </div>
                    @endif
                </div>
                <div class="col-2" id="gameSelectionColumn" name="gameSelection">
                    @if (!is_null($event->league))
                        @foreach ($event->league->leagueCategories as $leagueCategory)
                            <select name="gameSelection[]" class="form-select mb-3 gameSelection">
                                <option value="{{ $leagueCategory->src_game_id }}">
                                    {{ cache($leagueCategory->src_category_id)->game['data']['names']['international'] }}
                                </option>
                            </select>
                        @endforeach
                    @else
                        <select name="gameSelection[]" class="form-select mb-3 gameSelection">
                        </select>
                    @endif
                </div>
                <div class="col-2" id="categorySelectionColumn" name="categorySelection">
                    @if (!is_null($event->league))
                        @foreach ($event->league->leagueCategories as $leagueCategory)
                            <select name="categorySelection[]" class="form-select mb-3 categorySelection">
                                <option value="{{ $leagueCategory->src_category_id }}">
                                    {{ cache($leagueCategory->src_category_id)->name }}
                                </option>
                            </select>
                        @endforeach
                    @else
                        <select name="categorySelection[]" class="form-select mb-3 categorySelection">
                        </select>
                    @endif
                </div>
                <div class="col-2" id="bonusPointsColumn" name="bonusPoints">
                    @if (!is_null($event->league))
                        @foreach ($event->league->leagueCategories as $leagueCategory)
                            <input type="text" name="bonusPoints[]" class="form-control mb-3 game_id"
                                value="{{ $leagueCategory->bonus_points }}">
                        @endforeach
                    @else
                        <input type="number" name="bonusPoints[]" class="form-control mb-3 bonusPoints">
                    @endif
                </div>
                <div class="col-2" id="removeButtonColumn" name="removeCategoryUrl">
                    @if (!is_null($event->league))
                        @if (sizeof($event->league->leagueCategories) > 0)
                            @foreach ($event->league->leagueCategories as $leagueCategory)
                                <button class="btn btn-danger removeCategoryUrl d-block mb-3">
                                    <span class="fa-solid fa-minus"></span>
                                </button>
                            @endforeach
                        @else
                            <button class="btn btn-danger removeCategoryUrl d-block mb-3">
                                <span class="fa-solid fa-minus"></span>
                            </button>
                        @endif
                    @else
                        <button class="btn btn-danger removeCategoryUrl d-block mb-3">
                            <span class="fa-solid fa-minus"></span>
                        </button>
                    @endif
                </div>
            </div>
        </div>

        <div id="points_per_second_settings" hidden>
            <h3>Points Per Second Settings</h3>
            @if (!is_null($event->league))

                @foreach ($event->league->leagueCategories as $leagueCategory)
                    <h4>Thresholds for {{ $leagueCategory->hack->name }} - {{ $leagueCategory->category_name }}
                        <button
                            name="{{ substr($leagueCategory->category_url, strpos($leagueCategory->category_url, '.com/') + strlen('.com/')) }}"
                            value="{{ $leagueCategory->id }}" class="btn btn-primary ms-3 addThresholdButton">
                            <span class="fa-solid fa-plus"></span>
                        </button>
                    </h4>
                    <div class="row row-cols-5 align-items-start justify-content-between mb-3">
                        <div class="col-3">
                            <label for="cutoff" class="form-label">Cutoff</label>
                        </div>
                        <div class="col-3">
                            <label for="points_per_second" class="form-label">Points Per Second</label>
                        </div>
                        <div class="col-3">
                            <label for="tier" class="form-label">Tier</label>
                        </div>
                        <div class="col-3">
                            Remove Threshold
                        </div>
                    </div>

                    <div class="row row-cols-5 align-items-start justify-content-between mb-3"
                        id="{{ substr($leagueCategory->category_url, strpos($leagueCategory->category_url, '.com/') + strlen('.com/')) }}">
                        <div class="col-3" id="leagueCategoryIdColumn" name="league_category_id" hidden>
                            @if (sizeof($leagueCategory->leaguePointsPerSeconds) > 0)
                                @foreach ($leagueCategory->leaguePointsPerSeconds as $leaguePointsPerSecond)
                                    <input name="league_category_id[]" type="hidden"
                                        value="{{ $leagueCategory->id }}">
                                @endforeach
                            @else
                                <input name="league_category_id[]" type="hidden" value="{{ $leagueCategory->id }}">
                            @endif
                        </div>
                        <div class="col-3" id="cutoffColumn" name="cutoff">
                            @if (sizeof($leagueCategory->leaguePointsPerSeconds) > 0)
                                @foreach ($leagueCategory->leaguePointsPerSeconds as $leaguePointsPerSecond)
                                    <input type="text" name="cutoff[]" class="form-control mb-3"
                                        value="{{ $leaguePointsPerSecond->cutoff }}">
                                @endforeach
                            @else
                                <input type="text" name="cutoff[]" class="form-control mb-3">
                            @endif
                        </div>
                        <div class="col-3" id="pointsPerSecondColumn" name="pointsPerSecond">
                            @if (sizeof($leagueCategory->leaguePointsPerSeconds) > 0)
                                @foreach ($leagueCategory->leaguePointsPerSeconds as $leaguePointsPerSecond)
                                    <input type="number" name="pointsPerSecond[]" class="form-control mb-3"
                                        value="{{ $leaguePointsPerSecond->points_per_second }}"">
                                @endforeach
                            @else
                                <input type="number" name="pointsPerSecond[]" class="form-control mb-3">
                            @endif
                        </div>
                        <div class="col-3" id="tierColumn" name="tier">
                            @if (sizeof($leagueCategory->leaguePointsPerSeconds) > 0)
                                @foreach ($leagueCategory->leaguePointsPerSeconds as $leaguePointsPerSecond)
                                    <input type="number" name="tier[]" class="form-control mb-3"
                                        value="{{ $leaguePointsPerSecond->tier }}">
                                @endforeach
                            @else
                                <input type="number" name="tier[]" class="form-control mb-3">
                            @endif
                        </div>
                        <div class="col-3" id="removeThresholdColumn">
                            @if (sizeof($leagueCategory->leaguePointsPerSeconds) > 0)
                                @foreach ($leagueCategory->leaguePointsPerSeconds as $leaguePointsPerSecond)
                                    <button class="btn btn-danger mb-3 d-block">
                                        <span class="fa-solid fa-minus"></span>
                                    </button>
                                @endforeach
                            @else
                                <button class="btn btn-danger mb-3">
                                    <span class="fa-solid fa-minus"></span>
                                </button>
                            @endif
                        </div>
                    </div>
                    <hr />
                @endforeach
            @endif
        </div>

        <div id="league_participants_settings" hidden>
            <h3>League Participants Settings
                <button id="addParticipantButton" class="btn btn-primary ms-3">
                    <span class="fa-solid fa-plus"></span>Add Participant
                </button>
            </h3>
            @if (!is_null($event->league))
                <div class="row row-cols-5 align-items-start mb-3 justify-content-between">
                    <div class="col-4">
                        <label for="cutoff" class="form-label">name</label>
                    </div>
                    <div class="col-4">
                        <label for="points_per_second" class="form-label">src User Profile</label>
                    </div>
                    <div class="col-4">
                        Remove Player
                    </div>
                </div>

                <div class="row row-cols-5 align-items-start justify-content-between mb-3">
                    <div class="col-4" id="nameColumn" name="league_display_name">
                        @if (sizeof($event->league->leagueParticipants) > 0)
                            @foreach ($event->league->leagueParticipants as $leagueParticipant)
                                <input type="text" name="league_display_name[]" class="form-control mb-3"
                                    value="{{ $leagueParticipant->display_name }}">
                            @endforeach
                        @else
                            <input type="text" name="league_display_name[]" class="form-control mb-3">
                        @endif
                    </div>
                    <div class="col-4" id="srcNameColumn" name="srcName">
                        @if (sizeof($event->league->leagueParticipants) > 0)
                            @foreach ($event->league->leagueParticipants as $leagueParticipant)
                                <input type="text" name="srcName[]" class="form-control mb-3"
                                    value="{{ $leagueParticipant->src_name }}">
                            @endforeach
                        @else
                            <input type="text" name="src_Name[]" class="form-control mb-3">
                        @endif
                    </div>
                    <div class="col-4" id="removeParticipantColumn">
                        @if (sizeof($event->league->leagueParticipants) > 0)
                            @foreach ($event->league->leagueParticipants as $leagueParticipant)
                                <button class="btn btn-danger mb-3 d-block">
                                    <span class="fa-solid fa-minus"></span>
                                </button>
                            @endforeach
                        @else
                            <button class="btn btn-danger mb-3 d-block">
                                <span class="fa-solid fa-minus"></span>
                            </button>
                        @endif
                    </div>
                </div>
                <hr />
            @endif
        </div>

        <div class="row mb-4">
            <div class="col">
                <div id="editor-description"></div>
            </div>
        </div>
        <div class="d-flex justify-content-center">
            <div class="row w-25">
                <div class="col">
                    <button class="form-control btn btn-primary" type="submit">Save Changes</button>
                </div>
            </div>
        </div>
        <input type="hidden" name="description" id="description" value="{{ $event->description }}">
    </form>
</x-layout>
