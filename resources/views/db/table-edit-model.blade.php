<x-layout>
    <form method="post" action="/tables">
        @csrf
        @foreach ($model as $prop)
            @if ($prop['label'] != 'id')
                <label class="form-label" for="{{ $prop['label'] }}">
                    {{ $prop['label'] }} ({{ $prop['datatype'] }})
                </label>
            @endif
            @switch($prop['datatype'])
                @case('bigint')
                @case('decimal')
                @case('int')
                @case('mediumint')
                @case('smallint')
                    @if ($prop['label'] != 'id')
                        <input name="{{ $prop['label'] }}" class="form-control" type="number" value="{{ $prop['value'] }}" />
                    @endif
                @break

                @case('timestamp')
                    <input name="{{ $prop['label'] }}" class="form-control" type="datetime-local" value="{{ $prop['value'] }}" />
                @break

                @case('varchar')
                @case('char')
                    <input name="{{ $prop['label'] }}" class="form-control" type="text" value="{{ $prop['value'] }}" />
                @break

                @case('tinyint')
                    @if ($prop['value'] == 0)
                        <input name="{{ $prop['label'] }}" class="form-check" type="checkbox" value="true" />
                    @else
                        <input name="{{ $prop['label'] }}" class="form-check" type="checkbox" value="true" checked />
                    @endif
                    <input name="{{ $prop['label'] }}" type="hidden" value="false" />
                @break

                @default
                    @break
            @endswitch
            <hr />
        @endforeach
        <button class="btn btn-primary" type="submit">Save Data</button>
    </form>
</x-layout>
