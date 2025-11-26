<!DOCTYPE html>
<html lang="pl-PL">
    <head>
        @include('partials.head')
    </head>
    <body class="relative min-h-screen grid grid-rows-[auto_1fr_auto]">
        {{-- Header --}}
        <header class="bg-white border-b border-light-coffee">
            <div class="flex gap-8 items-center justify-between px-6 md:px-12 py-6 max-w-7xl mx-auto">
                {{-- Mobile Nav --}}
                <div x-data="{open: false}" class="lg:hidden">
                    <button type="button" class="block" @click="open = true">
                        <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect width="28" height="4" fill="#785f5f"/>
                            <rect y="12" width="28" height="4" fill="#785f5f"/>
                            <rect y="24" width="28" height="4" fill="#785f5f"/>
                        </svg>
                    </button>
                    <div class="fixed top-0 left-0 z-20 h-full bg-[#f4f4f4cc]" :class="open ? 'w-full' : 'w-0'">
                        <div x-cloak x-show="open"
                            x-transition:enter-start="-translate-x-full"
                            x-transition:leave-end="-translate-x-full"
                            class="bg-white px-8 py-8 h-full w-xs xs:w-sm transition-transform duration-300 ease-linear"
                        >
                            <button type="button" class="block ml-auto font-paragraph text-2xl/6 text-coffee" @click="open = false">
                                &#10006;
                            </button>
                            <nav class="my-32 xs:mx-8">
                                <ul class="flex flex-col gap-8 text-coffee font-technic text-xl">
                                    <li>
                                        <a href="/blog" wire:navigate>Wszystko o JDG | Blog</a>
                                    </li>
                                    <li>
                                        <a href="/shop" wire:navigate>Nasze produkty | Sklep</a>
                                    </li>
                                    <li>
                                        <a href="#" wire:navigate>O nas</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
                {{-- Logo --}}
                <h1 class="font-logo italic text-2xl/7 sm:text-4xl/9 text-coffee">
                    <a href="/">moja JDG</a>
                </h1>
                {{-- Large Screen Nav --}}
                <nav class="hidden lg:block">
                    <ul class="flex gap-8 text-coffee font-technic text-xl">
                        <li>
                            <a href="/blog" wire:navigate>Wszystko o JDG | Blog</a>
                        </li>
                        <li>
                            <a href="/shop" wire:navigate>Nasze produkty | Sklep</a>
                        </li>
                        <li>
                            <a href="#" wire:navigate>O nas</a>
                        </li>
                    </ul>
                </nav>
                {{-- Shopping Cart | User Icons --}}
                <ul class="flex gap-6">
                    <li>
                        <a href="{{ Auth::check() ? '/settings/profile' : '/login' }}" wire:navigate>
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="12" cy="7" r="4" stroke="#785f5f" stroke-width="1.5"/>
                                <path d="M3 20C5.19728 17.545 8.39043 16 11.9444 16C15.4984 16 18.6916 17.545 20.8889 20" stroke="#785f5f" stroke-width="1.5" stroke-linecap="round"/>
                            </svg>
                        </a>
                    </li>
                    <li>
                        <livewire:shop.cart-link-icon />
                    </li>
                </ul>
            </div>
        </header>
        {{-- Main Section --}}
        <main class="max-w-7xl w-full mx-auto">
            {{ $slot }}
        </main>
        {{-- Footer --}}
        <footer class="bg-white border-t border-light-coffee">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-2 max-w-7xl mx-auto px-6 md:px-12 py-4">
                <h1 class="font-logo italic text-2xl/6 text-coffee">
                    <a href="/">moja JDG</a>
                </h1>
                <nav>
                    <ul class="flex gap-8 text-coffee font-technic text-lg">
                        <li>
                            <a href="/blog" wire:navigate>Blog</a>
                        </li>
                        <li>
                            <a href="/shop" wire:navigate>Sklep</a>
                        </li>
                        <li>
                            <a href="#" wire:navigate>O nas</a>
                        </li>
                    </ul>
                </nav>
                @if (Auth::user() && Auth::user()->is_admin)
                    <a href="/admin" wire:navigate class="text-coffee font-technic text-lg">
                        panel administratora
                    </a>
                @else
                    <div class="text-coffee font-technic text-lg">
                        miłosz_gajda &copy;
                    </div>
                @endif
            </div>
        </footer>
    </body>
</html>