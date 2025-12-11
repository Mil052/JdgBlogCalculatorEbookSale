<?php

use Livewire\Volt\Component;
use App\Models\BlogPost;

new class extends Component {
    public $posts;
    public $lastPost;
    public $lastPostImage;

    private $postColorsClasses = [
        0 => ['bg-color' => 'bg-coffee', 'text-color' => 'text-white', 'box-color' => 'bg-white', 'icon-color' => '#ffffff'],
        1 => ['bg-color' => 'bg-light-grey', 'text-color' => 'text-black', 'box-color' => 'bg-neutral-900', 'icon-color' => '#000000'],
        2 => ['bg-color' => 'bg-dark-grey', 'text-color' => 'text-white', 'box-color' => 'bg-white', 'icon-color' => '#ffffff'],
        3 => ['bg-color' => 'bg-cream', 'text-color' => 'text-black', 'box-color' => 'bg-neutral-900', 'icon-color' => '#000000'],
        4 => ['bg-color' => 'bg-light-blue', 'text-color' => 'text-black', 'box-color' => 'bg-neutral-900', 'icon-color' => '#000000'],
    ];

    public function mount()
    {
        $this->posts = BlogPost::where('publish', true)->latest()->get();
        $this->lastPost = $this->posts->shift();
        $this->lastPostImage = $this->lastPost->assets()->first();
    }
}; ?>

<section>
    <h1 class="bg-white page-title px-8 xs:px-16 lg:px-32 py-20">Blog</h1>
    <div class="bg-light-grey px-4 sm:px-8 py-8 flex gap-8 md:gap-12 flex-col sm:flex-row">
        <div>
            <div class="flex gap-8">
                <div class="bg-cream aspect-square min-h-10"></div>
                <h3 class="self-center font-title text-xl sm:text-2xl">{{ $lastPost->title }}</h3>
            </div>
            <p class="font-paragraph my-8 text-sm sm:text-base">{{ $lastPost->excerpt }}</p>
            <div class="flex gap-12 justify-between text-sm sm:text-base">
                <address class="author font-light">{{ $lastPost->author }}</address>
                <a href="/blog/{{ $lastPost->id }}" class="font-technic text-sea-dark">
                    przejdź do artykułu
                    <span class="text-xl/5">&#8594;</span>
                </a>
            </div>
        </div>
        <img src="{{ isset($lastPostImage) ? '/storage/blog_posts_assets/' . $lastPostImage->file_name : '/assets/office.webp' }}" alt="blog article image" class="block min-w-50 sm:w-1/4 object-cover rounded-sm">
    </div>
    <div class="py-12 px-4 mb-16">
        <ul class="grid gap-4 xs:grid-cols-4 lg:grid-cols-6">
            @foreach ($posts as $post)
                <li
                    wire:key="{{ $post->id }}"
                    @class([
                        'flex',
                        'flex-col',
                        'gap-6',
                        'p-4',
                        'rounded-sm',
                        'shadow-[6px_6px_6px_#00000040]',
                        // background color and text color
                        $this->postColorsClasses[$loop->index % 5]['bg-color'],
                        $this->postColorsClasses[$loop->index % 5]['text-color'],
                        // layout
                        'xs:col-span-3 lg:col-span-2 lg:row-span-2' => ($loop->index % 6) === 0,
                        'col-span-full lg:col-span-4' => ($loop->index % 6) === 1,
                        'xs:col-span-3 sm:col-span-2 lg:row-span-2' => ($loop->index % 6) === 2,
                        'xs:col-start-2 xs:col-span-3 sm:col-span-2 lg:col-start-auto lg:row-span-3' => ($loop->index % 6) === 3,
                        'xs:col-span-3 lg:row-span-2' => ($loop->index % 6) === 4,
                        'xs:col-start-2 xs:col-span-3 lg:col-start-auto' => ($loop->index % 6) === 5,
                    ])
                >
                    <div class="flex gap-4">
                        <div
                            @class([
                                'min-w-2',
                                $this->postColorsClasses[$loop->index % 5]['box-color'],
                            ]),
                        ></div>
                        <h3 class="font-title text-xl sm:text-2xl">{{ $post->title }}</h3>
                    </div>
                    <p class="font-paragraph text-sm sm:text-base font-light grow">
                        {{ $post->excerpt }}
                    </p>
                    <a href="/blog/{{ $post->id }}" class="self-end">
                       <x-icon.sqr-arrow-down class="w-6 h-6" :color="$this->postColorsClasses[$loop->index % 5]['icon-color']"/>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</section>
