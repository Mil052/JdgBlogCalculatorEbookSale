<!DOCTYPE html>
<!--<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark"> -->
<html lang="pl-PL">
    <head>
        @include('partials.head')
    </head>
    <body class="bg-light-grey max-w-7xl mx-auto">
        <div class="min-h-full grid grid-rows-[auto_1fr] lg:grid-rows-1 lg:grid-cols-[360px_1fr] bg-white">
            <!-- Navigation -->
            @persist('navigation')
            <div x-data="{openMobileMenu: false}" class="h-full">
                <!-- Mobile Navigation Header -->
                <header class="lg:hidden p-8">
                    <button @click="openMobileMenu = true">
                        <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect width="28" height="4" fill="#785f5f"/>
                            <rect y="12" width="28" height="4" fill="#785f5f"/>
                            <rect y="24" width="28" height="4" fill="#785f5f"/>
                        </svg>
                    </button>
                </header>
                <div class="fixed top-0 lg:static z-20 h-full">
                    <!-- Mobile Navigation Backdrop -->
                    <div x-show="openMobileMenu" class="absolute bg-coffee/75 h-full w-screen z-10 lg:hidden"></div>
                    <!-- User Panel Menu -->
                    <aside
                        style="background-image: url(/storage/paper-vertical.svg)"
                        class="absolute lg:static z-20 h-full w-90 bg-no-repeat bg-cover bg-right drop-shadow-[8px_2px_4px_#0000004d] pl-8 pr-20 py-8 flex flex-col gap-16 transition-[translate] duration-300 lg:translate-none"
                        :class="openMobileMenu ? 'translate-none' : '-translate-x-full'"
                    >
                        <div class="self-end h-7">
                            <button class="lg:hidden block" @click="openMobileMenu = false">
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
                        <!-- Logout button -->
                        <form method="POST" action="{{ route('logout') }}" class="w-full mt-auto">
                            @csrf
                            <button type="submit">
                                Log Out
                            </button>
                        </form>
                    </aside>
                </div>
            </div>
            @endpersist
            <main class="p-4 sm:p-8 lg:py-16">
                {{ $slot }}
            </main>
            @fluxScripts
            @livewireScriptConfig
        </div>
    </body>
</html>