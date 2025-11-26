<?php

use Livewire\Volt\Component;
use App\Models\BlogPost;
use Illuminate\Support\Str;

new class extends Component {

    public BlogPost $post;

    public function mount(BlogPost $post)
    {
        $this->post = $post;
        $this->post->content = Str::markdown($this->post->content);
    }
}; ?>

<section class="h-full section bg-light-grey">
    <h1 class="heading-lg">{{ $post->title }}</h1>
    <div class="blog-post my-16">
        {!! $post->content !!}
    </div>
    <div class="flex justify-between font-paragraph text-lg">
        <p>{{ $post->created_at->toDateString() }}</p>
        <p class="italic">{{ $post->author}}</p>
    </div>
</section>
