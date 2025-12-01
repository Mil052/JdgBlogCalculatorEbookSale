<!DOCTYPE html>
<html lang="pl-PL">
    <head>
        @include('partials.head')
    </head>
    <body class="bg-light-grey min-h-screen grid grid-rows-[auto_1fr_auto]">
        <header class="bg-white">
            <div class="relative max-w-7xl mx-auto flex justify-between items-center px-6 md:px-12 py-6">
                <a href="/">
                    <h1 class="font-logo italic text-2xl sm:text-3xl">moja JDG</h1>
                    <div class="font-technic text-xs sm:text-sm">
                        <span>strona główna</span>
                        <span class="ml-1">&#8594;</span>
                    </div>
                </a>
                {{-- Screen navigation --}}
                <nav class="hidden sm:block">
                    <ul class="flex gap-6 md:gap-8">
                        <li>
                            <a href="/admin" wire:navigate>Admin Panel</a>
                        </li>
                        <li>
                            <a href="/admin/products" wire:navigate>Produkty</a>
                        </li>
                        <li>
                            <a href="/admin/blog" wire:navigate>Blog</a>
                        </li>
                        <li>
                            <a href="/admin/orders" wire:navigate>Zamówienia</a>
                        </li>
                    </ul>
                </nav>
                {{-- Mobile Navigation --}}
                <div x-data="{open: false}" class="sm:hidden">
                    <button class="flex gap-3 items-center w-35 justify-between pt-2 border-coffee" :class="open ? 'pb-2' : ' pb-1 border-b-4'" type="button" @click="open = !open">
                        <span>
                            {{ routeToName(Illuminate\Support\Facades\Route::currentRouteName()) }}
                        </span>
                        <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1 4L10 12L19 4" stroke="black" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                    <div 
                        class="absolute right-0 top-full bg-white p-6 transition-transform duration-200 ease-linear origin-top"
                        x-show="open"
                        x-transition:enter-start="scale-y-0"
                        x-transition:leave-end="scale-y-0"
                    >
                        <nav class="w-35 opacity-0" :class="open ? 'animate-emerge' : ''">
                            <ul>
                                <li class="my-3 pt-2 pb-2 hover:border-b-2 hover:pb-[6px]">
                                    <a href="/admin" wire:navigate>Admin Panel</a>
                                </li>
                                <li class="my-3 pt-2 pb-2 hover:border-b-2 hover:pb-[6px]">
                                    <a href="/admin/products" wire:navigate>Produkty</a>
                                </li>
                                <li class="my-3 pt-2 pb-2 hover:border-b-2 hover:pb-[6px]">
                                    <a href="/admin/blog" wire:navigate>Blog</a>
                                </li>
                                <li class="my-3 pt-2 pb-2 hover:border-b-2 hover:pb-[6px]">
                                    <a href="/admin/orders" wire:navigate>Zamówienia</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </header>
        <main>
            {{ $slot }}
        </main>
        <footer class="bg-white">
            <nav class="max-w-7xl mx-auto px-6 md:px-12 py-6">
                <ul class="flex gap-12 items-center">
                    <li>
                        <a href="{{ route('home') }}" wire:navigate>
                            <span>strona główna</span>
                            <span class="ml-1 text-xl/6">&#8594;</span>
                        </a>
                    </li>
                    <li class="ml-auto">
                        <!-- Logout button -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit">
                                Log Out
                            </button>
                        </form>
                    </li>
                </ul>
            </nav>
        </footer>
        @livewireScriptConfig
    </body>
</html>