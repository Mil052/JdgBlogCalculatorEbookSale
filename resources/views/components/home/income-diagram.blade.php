@props(["total", "checked" ])

<div>
    <svg width="497" height="64" viewBox="0 0 497 64" fill="none" xmlns="http://www.w3.org/2000/svg">
        @for ($i = 0; $i < $total; $i++)
            <rect
                x="{{ $i * 5 }}"
                width="2"
                height="64"
                fill="{{ $i < $checked ? '#2E2E2E' : '#F4F4F4' }}"
            />
        @endfor
    </svg>
</div>