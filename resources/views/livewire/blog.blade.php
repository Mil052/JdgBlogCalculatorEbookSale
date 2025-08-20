<?php

use Livewire\Volt\Component;
use App\Models\BlogPost;

new class extends Component {
    public $posts;

    public function mount()
    {
        $this->posts = BlogPost::where('publish', true)->get();
    }
}; ?>

<section>
    <h1>Moja JDG - BLOG</h1>
    <h2>
        W poniższych artykułach wyjaśniamy kluczowe kwestie podatkowe dotyczące prowadzenia jednoosobowej działalności gospodarczej.
    </h2>
    <hr>
    <ul>
        @foreach ($posts as $post)
            <li wire:key="{{ $post->id }}">
                <a href="/blog/{{ $post->id }}">
                    {{ $post->title }}
                </a>
            </li>
        @endforeach
    </ul>
</section>
