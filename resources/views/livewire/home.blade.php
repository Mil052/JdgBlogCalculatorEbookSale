<?php
use Livewire\Volt\Component;
use App\Models\BlogPost;

new class extends Component {

    public $newestPost;

    public function mount() 
    {
        $this->newestPost = BlogPost::orderBy('created_at', 'desc')->first();
    }

}; ?>

<div>
    <section>
        <x-hero :title="$newestPost->title" :excerpt="$newestPost->excerpt" :author="$newestPost->author" :created_at="$newestPost->created_at->toDateString()" :id="$newestPost->id"/>
    </section>
    <section class="px-4 lg:px-8 py-8 md:py-16">
        <livewire:tax-calculator.tax-counter />
    </section>
    <section class="px-1 xs:px-4 lg:px-8 py-8 md:py-16 grid md:grid-cols-[3fr_2fr]">
        <div class="relative w-9/10 md:w-full">
            <x-tax-office-advertisement />
        </div>  
        <div class="relative w-9/10 left-1/10 -top-12 md:w-[calc(100%+3rem)] md:top-0 md:-left-12 md:mt-20">
            <livewire:contact.contact-form />
        </div>
    </section>
    <section class="py-8 bg-light-grey">
        <div class="mx-4 lg:mx-8 mb-12 flex justify-between items-end">
            <h2 class="heading-lg">Nasze produkty</h2>
            <a href="/shop" class="flex gap-6 items-end text-sea-dark">
                <span class="hidden sm:inline">zobacz wszystkie</span>
                <x-icon.sqr-arrow-down class="w-8 h-8 mb-1"/>
            </a>
        </div>
        <livewire:products-slider.slider />
    </section>
</div>
