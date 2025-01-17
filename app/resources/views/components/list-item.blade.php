@props([
    'avatarUrl' => null,
    'avatarStyle' => null,
    'title' => null,
    'emoji' => null,
    'subtitle' => null,
    'position' => null,
    'stats' => null,
    'searchKey' => null,
    'url' => null
])

<li
    {{ $attributes->bem('list-item') }}
    x-data="listItem({{ json_encode($searchKey) }})"
    x-show="matchesSearchQuery"
>
    @if ($avatarUrl)
        <x-avatar
            :url="$avatarUrl"
            class="list-item__avatar"
            :style="$avatarStyle"
        />
    @endif

    <div class="list-item__text">
        <strong>
            @if ($url)
                <a href="{{$url}}">
                    {{ $title }} {{ $emoji }}
                </a>
            @else
                {{ $title }} {{ $emoji }}
            @endif
        </strong>

        <div class="list-item__subtitle">
            {{ $subtitle }}
        </div>

        @if ($stats)
            <x-vote-result-chart
                :stats="$stats"
                style="slim"
                class="list-item__chart"
            />
        @endif
    </div>

    @if ($position)
        <span class="visually-hidden">
            {{ Str::lower($position->label) }}
        </span>

        <x-thumb :position="$position" style="circle" class="list-item__thumb"/>
    @endif
</li>
