<!DOCTYPE html>
<html lang="pl-PL">
    <head>
        @include('partials.head')
    </head>
    <body class="bg-light-grey min-h-screen max-w-7xl mx-auto grid grid-rows-[auto_1fr_auto]">
        <header>
            <nav class="flex justify-between items-center">
                <h1 class="font-logo italic text-4xl">
                    <a href="/">moja JDG</a>
                </h1>
                <ul class="flex gap-8">
                    <li>
                        <a href="/blog" wire:navigate>Wszystko o JDG | Blog</a>
                    </li>
                    <li>
                        <a href="/shop" wire:navigate>Nasze Książki | Sklep</a>
                    </li>
                    <li>
                        <a href="#" wire:navigate>O nas</a>
                    </li>
                </ul>
                <ul class="flex gap-6">
                    <li>
                        <a href="{{ Auth::check() ? '/settings/profile' : '/login' }}" wire:navigate>
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="12" cy="7" r="4" stroke="black" stroke-width="1.5"/>
                                <path d="M3 20C5.19728 17.545 8.39043 16 11.9444 16C15.4984 16 18.6916 17.545 20.8889 20" stroke="black" stroke-width="1.5" stroke-linecap="round"/>
                            </svg>
                        </a>
                    </li>
                    <li>
                        <livewire:shop.cart-link-icon/>
                    </li>
                </ul>
            </nav>
        </header>
        <main>
            {{ $slot }}
        </main>
        <footer>
            <a href="/admin" wire:navigate>panel administratora</a>
        </footer>
    </body>
</html>