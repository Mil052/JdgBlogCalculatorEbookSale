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

<section>
    <h1>{{ $post->title }}</h1>
    <div>
        {!! $post->content !!}
    </div>
    <div class="flex justify-between">
        <p>{{ $post->author}}</p>
        <p>{{ $post->created_at }}</p>
    </div>
</section>
