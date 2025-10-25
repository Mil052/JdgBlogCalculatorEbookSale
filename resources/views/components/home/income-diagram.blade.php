@props(["id", "total", "checked" ])

<div
    x-data="{animation: $el.querySelector('#{{ $id }}Animation')}"
    x-on:updatediagram.document="animation.beginElement();"
>
    <svg viewBox="0 0 497 64" fill="none" xmlns="http://www.w3.org/2000/svg">
        <set
            id="{{ $id . 'Animation' }}"
            dur="200ms"
        />
        @for ($i = 0; $i < $total; $i++)
            <rect
                x="{{ $i * 5 }}"
                width="2"
                height="64"
                fill="#F4F4F4"
            >
                <set
                    attributeName="fill"
                    to="#F4F4F4"
                    begin="{{ $id . 'Animation.begin'}}"
                />
                <set
                    attributeName="fill"
                    to="{{ $i < $checked ? '#2E2E2E' : '#F4F4F4' }}"
                    begin="{{ ($i * 10) . 'ms;' . $id . 'Animation.end + ' . ($i * 10) . 'ms' }}"
                    dur="indefinite"
                    fill="freeze"
                />
            </rect>
        @endfor
    </svg>
</div>