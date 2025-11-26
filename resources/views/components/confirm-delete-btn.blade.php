
@props(['title', 'type', 'id'])

<div x-data="{ open: false }" {{ $attributes }}>
    <button type="button" @click="open = true" class="block">
        <x-icon.bin />
    </button>
    <div x-cloak x-show="open" class="fixed inset-0 z-10 bg-coffee/80 p-6 sm:p-12 flex items-center">
        <div class="mx-auto bg-white px-4 py-8 xs:p-12 max-w-120 rounded-sm shadow-[6px_6px_6px_#00000040]">
            <h1 class="font-technic text-lg">Usuń {{ $type }}</h1>
            <hr class="my-4">
            <div class="font-paragraph my-8">
                <h3 class="text-sm font-light">{{ $type }} id:&nbsp;{{ $id }}</h3>
                <h2 class="text-lg font-semibold">{{ $title }}</h2>
            </div>
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