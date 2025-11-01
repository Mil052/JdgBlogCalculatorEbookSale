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
        <x-hero :title="$newestPost->title" :excerpt="$newestPost->excerpt" :author="$newestPost->author" :created_at="$newestPost->created_at" :id="$newestPost->id"/>
    </section>
    <section class="section">
        <livewire:tax-calculator.tax-counter />
    </section>
    <section class="section grid grid-cols-[3fr_2fr]">
        <div>
            <x-tax-office-advertisement />
        </div>  
        <div class="relative w-[calc(100%+3rem)] top-20 -left-12 mb-20">
            <livewire:contact.contact-form />
        </div>
    </section>
</div>
