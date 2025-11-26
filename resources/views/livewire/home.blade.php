<?php
use Livewire\Volt\Component;
use App\Models\BlogPost;

new class extends Component {

    public $newestPost;

    public function mount() 
    {
        $this->newestPost = BlogPost::orderBy('created_at', 'desc')->first();
    }

    // public function with(): array {}
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
</div>
