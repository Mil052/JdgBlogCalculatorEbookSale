<!DOCTYPE html>
<html lang="pl-PL">
    <head>
        @include('partials.head')
    </head>
    <body class="relative min-h-screen grid grid-rows-[auto_1fr_auto]">
        <header class="bg-white">
            <nav class="flex justify-between items-center px-12 py-6 max-w-7xl mx-auto">
                <h1 class="font-logo italic text-4xl/9 text-coffee">
                    <a href="/">moja JDG</a>
                </h1>
                <ul class="flex gap-8 text-coffee font-technic text-xl">
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
                        <livewire:shop.cart-link-icon />
                    </li>
                </ul>
            </nav>
        </header>
        <main class="max-w-7xl w-full mx-auto">
            {{ $slot }}
        </main>
        <footer class=" bg-coffee">
            <div class="flex items-center justify-between max-w-7xl mx-auto px-12 py-4">
                <h1 class="font-logo italic text-2xl/6 text-white">
                    <a href="/">moja JDG</a>
                </h1>
                <nav class="flex justify-between items-center">
                    <ul class="flex gap-8 text-white font-technic text-lg font-light">
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
                </nav>
                @if (Auth::user() && Auth::user()->is_admin)
                    <a href="/admin" wire:navigate text-white font-technic text-lg font-light>
                        panel administratora
                    </a>
                @else
                    <div class="text-white font-technic text-lg font-light">
                        miłosz_gajda &copy;
                    </div>
                @endif
            </div>
        </footer>
    </body>
</html>