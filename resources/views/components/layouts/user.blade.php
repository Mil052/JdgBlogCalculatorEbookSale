<!DOCTYPE html>
<!--<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark"> -->
<html lang="pl-PL">
    <head>
        @include('partials.head')
    </head>
    <body class="bg-light-grey min-h-screen max-w-7xl mx-auto">
        <div class="h-full grid grid-rows-[auto_1fr] md:grid-rows-1 md:grid-cols-[360px_1fr] bg-cream">
            <!-- Navigation -->
            @persist('navigation')
            <div x-data="{openMobileMenu: false}" class="h-full">
                <!-- Mobile Navigation Header -->
                <header class="md:hidden">
                    <button class="md:hidden" @click="openMobileMenu = true">open</button>
                </header>
                <div class="fixed top-0 md:static z-20 h-full">
                    <!-- Mobile Navigation Backdrop -->
                    <div x-show="openMobileMenu" class="absolute bg-coffee/75 h-full w-screen z-10 md:hidden"></div>
                    <!-- User Panel Menu -->
                    <aside
                        style="background-image: url(/storage/paper-vertical.svg)"
                        class="absolute md:static z-20 h-full w-90 bg-no-repeat bg-cover bg-right pl-8 pr-20 py-8 flex flex-col gap-16 transition-[translate] duration-300 md:translate-none"
                        :class="openMobileMenu ? 'translate-none' : '-translate-x-full'"
                    >
                        <div class="self-end h-7">
                            <button class="md:hidden block" @click="openMobileMenu = false">
                                <x-icon.close/>
                            </button>
                        </div>
                        <a href="/">
                            <h1 class="font-logo italic text-2xl">moja JDG</h1>
                            <div class="font-technic text-sm">
                                <span>strona główna</span>
                                <span class="ml-1">&#8594;</span>
                            </div>
                        </a>
                        <nav class="font-paragraph">
                            <ul>
                                <li class="my-4" @click="openMobileMenu = false">
                                    <a href="{{ route('dashboard') }}" wire:navigate>
                                        Panel użytkownika
                                    </a>
                                </li>
                                <li class="my-4" @click="openMobileMenu = false">
                                    <a href="{{ route('settings.profile') }}" wire:navigate>
                                        Ustawienia
                                    </a>
                                </li>
                            </ul>
                        </nav>
                        <!-- Logout button -->
                        <form method="POST" action="{{ route('logout') }}" class="w-full mt-auto">
                            @csrf
                            <button type="submit" class="w-full">
                                Log Out
                            </button>
                        </form>
                    </aside>
                </div>
            </div>
            @endpersist
            <main class="px-8 py-16">
                {{ $slot }}
            </main>
            @fluxScripts
        </div>
    </body>
</html>