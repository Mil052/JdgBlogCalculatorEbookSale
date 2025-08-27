<?php
use Livewire\Attributes\{Layout, Title};
use Livewire\Volt\Component;
use App\Models\BlogPost;
use App\Models\BlogPostAsset;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Storage;

new
#[Layout('components.layouts.admin')]
#[Title('JDG Panel Administratora')]
class extends Component {
    #[Computed]
    public function posts()
    {
        return BlogPost::all();
    }

    protected $colors = ['#785F5F', '#FFE2A2', '#974141', '#90BAC3'];
    protected $colorsCount;

    public function mount()
    {
        $this->colorsCount = count($this->colors);
    }

    public function deletePost(BlogPost $post)
    {
        $assets = $post->assets->map(function (BlogPostAsset $asset) {
            return 'blog_posts_assets/' . $asset->file_name;
        })->toArray();

        $assetsDeleted = Storage::disk('public')->delete($assets);
        
        if ($assetsDeleted) {
            $post->delete();
        } else {
            abort(500);
        }
    }
}; ?>

<section class="area">
    <h1 class="heading-base">BLOG POST LIST</h1>
    <hr class="my-8">
    <ul>
        @foreach ($this->posts as $post)
            <li wire:key="{{ $post->id }}" class="group flex my-8 gap-12 justify-between items-center">
                <div class="flex gap-6">
                    <div class="min-w-7">
                        <div style="background-color: {{ $this->colors[$loop->index % $this->colorsCount] }}" class="w-3 h-full group-hover:w-7 transition-[width] duration-300"></div>
                    </div>
                    <a href="/blog/{{ $post->id }}">
                        <h2 class="inline font-paragraph text-lg font-normal mr-2">{{ $post->title }}</h2>
                        <span class="text-sm">(post&nbsp;id:&nbsp;{{ $post->id }})</span>
                    </a>
                </div>
                <div class="flex gap-6">
                    <a href="/admin/blog/post/{{ $post->id }}/edit">
                        <x-icon.pen />
                    </a>
                    <x-post-delete-btn :title="$post->title" @delete="$wire.deletePost({{ $post->id }})"/>
                </div>
            </li>
        @endforeach
    </ul>
</section>
