
@props(['title', 'type', 'id'])

<div x-data="{ open: false }" {{ $attributes }}>
    <button type="button" @click="open = true" class="block">
        <x-icon.bin />
    </button>
    <div x-cloak x-show="open" class="fixed inset-0 z-10 bg-coffee/80 p-12 flex justify-center items-center">
        <div class="bg-white p-12 sm:w-120">
            <h1 class="font-technic text-lg">Usuń {{ $type }}</h1>
            <hr class="my-4">
            <h2 class="font-paragraph text-lg font-semibold my-8">
                {{ $title }}
                <span class="ml-3 font-light">({{ $type }} id:&nbsp;{{ $id }})</span>
            </h2>
            <p class="font-technic my-8">Czy napewno chcesz usunąć {{ $type }}?</p>
            <div class="flex gap-4 justify-end">
                <button type="button" @click="open = false" class="btn-secondary">
                    Anuluj
                </button>
                <button type="button" @click="$dispatch('delete')" class="btn-primary">
                    Usuń
                </button>
            </div>
        </div>
    </div>
</div>