@foreach ($blocks as $block)
    <div id="{{ $block['id'] }}">
        @switch($block['type'])
            @case('link')
                <p><a href="{{ $block['data']['link'] }}">{{ $block['data']['link'] }}</a></p>
            @break

            @case('paragraph')
                <p>{!! $block['data']['text'] !!}</p>
            @break

            @case('header')
                <h{{ $block['data']['level'] }}>{{ $block['data']['text'] }}</h{{ $block['data']['level'] }}>
                @break

                @case('list')
                    @switch($block['data']['style'])
                        @case('unordered')
                            <ul>
                                @foreach ($block['data']['items'] as $item)
                                    <li>{{ $item['content'] }}</li>
                                @endforeach
                            </ul>
                        @break

                        @case('ordered')
                            <ol>
                                @foreach ($block['data']['items'] as $item)
                                    <li>{{ $item['content'] }}</li>
                                @endforeach
                            </ol>
                        @break

                        @case('checklist')
                            @foreach ($block['data']['items'] as $item)
                                <div class="form-check">
                                    @if ($item['meta']['checked'])
                                        <input class="form-check-input" type="checkbox" onclick="return false;" checked>
                                    @else
                                        <input class="form-check-input" type="checkbox" onclick="return false;" readonly>
                                    @endif
                                    <label class="form-check-label">{{ $item['content'] }}</label>
                                </div>
                            @endforeach
                        @break

                        @default
                        @break
                    @endswitch

                    @default
                    @break

                @endswitch
        </div>
    @endforeach
