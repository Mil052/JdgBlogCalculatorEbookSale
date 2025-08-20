
@props(['title'])

<div x-data="{ open: false }" {{ $attributes }}>
    <button type="button" @click="open = true">
        usuń
    </button>
    <div x-show="open" class="fixed inset-0 z-10 bg-coffee/80 p-8">
        <div class="absolute inset-1/5 z-20 bg-white p-8">
            <p>
                Czy napewno chcesz usunąć post
                <span>"{{ $title }}"</span>
                ?
            </p>
            <div>
                <button type="button" @click="$dispatch('delete')">usuń</button>
                <button type="button" @click="open = false">anuluj</button>
            </div>
        </div>
    </div>
</div>