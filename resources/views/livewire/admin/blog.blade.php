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

    public function deletePost(BlogPost $post)
    {
        $assets = $post->assets->map(function (BlogPostAsset $asset) {
            return 'blog_posts_assets/' . $asset->file_name;
        })->toArray();

        $assetsDeleted = Storage::delete($assets);
        
        if ($assetsDeleted) $post->delete();
    }
}; ?>

<section class="section">
    <h1>BLOG POST LIST</h1>
    <ul>
        @foreach ($this->posts as $post)
            <li wire:key="{{ $post->id }}" class="flex justify-between">
                <a href="/blog/{{ $post->id }}">
                    {{ $post->title }}
                    <span class="ml-2 text-sm">(post id: {{ $post->id }})</span>
                </a>
                <div class="flex gap-4">
                    <a href="/admin/blog/post/{{ $post->id }}/edit">edytuj</a>
                    <x-post-delete-btn :title="$post->title" @delete="$wire.deletePost({{ $post->id }})"/>
                </div>
            </li>
        @endforeach
    </ul>
</section>
