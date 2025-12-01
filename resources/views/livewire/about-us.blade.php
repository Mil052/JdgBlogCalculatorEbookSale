<?php
use Livewire\Attributes\{Layout, Title};
use Livewire\Volt\Component;

new
#[Layout('components.layouts.app')]
#[Title('Moja JDG - O Nas')]
class extends Component {
    //
}; ?>

<section>
    <h1 class="bg-white page-title px-16 sm:px-35 py-20">O Nas</h1>
    <div class="px-4 sm:px-8 py-12 flex flex-col lg:flex-row gap-16 lg:gap-12">
        <article>
            <h3 class="info-base text-coffee">
                Poznajmy się - czyli kilka słów o Nas.
            </h3>
            <div class="flex gap-3 my-12">
                <div class="bg-cream min-w-8"></div>
                <h2 class="heading-base">
                    Generalnie tu będzie tekst o tym jak wspaniałymi osobami jesteśmy i dlaczego warto nas czytać.
                </h2>
            </div>
            <div class="paragraph my-12">
                <p class="my-3">
                    Tematem jednoosobowej działalności gospodarczej zajmujemy się od wielu lat ...
                </p>
                <p class="my-3">
                    W 2024 rozpoczeliśmy pisanie bloga i działalność informacyjno-edykacyjną  mającą na celu ...
                </p>
                <p class="my-3">
                    W 2025 roku planujemy wydanie e-booka podsumowującego najczęściej napotykane problemy w prowadzeniu JDG i proponowane rozwiązania...
                </p>
            </div>
        </article>
        <div x-data="{ show: false }" x-intersect.once.threshold.60="show = true" class="flex max-w-2xl self-center lg:self-stretch">
            <figure class="w-[calc((1/2_*_100%)_+_8px)] lg:w-3xs xl:w-2xs relative z-10">
                <img src="/assets/woman-01.webp" alt="young woman" class="lg:min-w-3xs xl:min-w-2xs rounded-sm opacity-0" :class="{ 'animate-slide-in-left-bottom' : show }"/>
                <figcaption class="font-technic text-xs xs:text-sm text-coffee">
                    Jan Kowalski - z zawodu radca prawny, prywatnie mąż, ojciec i triathlonista
                </figcaption>
            </figure>
            <figure class="w-[calc((1/2_*_100%)_-_8px)] lg:w-56 xl:w-3xs relative -top-16">
                <img src="/assets/woman-02.webp" alt="young woman" class="relative -left-8 min-w-[calc(100%_+_16px)] lg:min-w-3xs xl:min-w-2xs rounded-sm opacity-0" :class="{'animate-slide-in-right-top' : show}"/>
                <figcaption class="ml-3 font-technic text-xs xs:text-sm text-coffee">
                    Jan Kowalski - z zawodu radca prawny, prywatnie mąż, ojciec i triathlonista
                </figcaption>
            </figure>
        </div>
    </div>
</section>
