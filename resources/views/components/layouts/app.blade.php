<!DOCTYPE html>
<html lang="pl-PL">
    <head>
        @include('partials.head')
    </head>
    <body class="bg-light-grey min-h-screen max-w-7xl mx-auto grid grid-rows-[auto_1fr_auto]">
        <header class="flex justify-between">
            <h1 class="font-logo italic text-4xl">
                <a href="/" >moja JDG</a>
            </h1>
            <nav>
                <ul class="flex gap-8">
                    <li>
                        <a href="/blog" wire:navigate>Blog</a>
                    </li>
                    <li>
                        @if (Auth::check())
                            <a href="/settings/profile" wire:navigate>Panel użytkownika</a>
                        @else
                            <a href="/login" wire:navigate>Zaloguj się|Zarejestruj się</a>
                        @endif
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