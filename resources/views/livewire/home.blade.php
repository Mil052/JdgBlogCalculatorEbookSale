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
    <section>
        <livewire:home.tax-counter />
    </section>
    <section>
        O NAS...
    </section>
</div>
