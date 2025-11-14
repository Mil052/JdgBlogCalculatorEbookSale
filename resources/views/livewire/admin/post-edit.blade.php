<?php
use App\Livewire\Forms\BlogPostForm;
use Livewire\Attributes\{Layout, Title};
use Livewire\Volt\Component;
use App\Models\BlogPost;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use App\Models\BlogPostAsset;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;

new
#[Layout('components.layouts.admin')]
#[Title('JDG Panel Administratora')]
class extends Component {
    use WithFileUploads;

    public $title;

    // blog Post
    public BlogPost $post;
    public BlogPostForm $form;

    // Blog Post assets
    public Collection $assets;

    #[Validate('image|max:1024')]
    public $image;
    public $imageAlt;
    public $imageSource;

    public function mount($id = null)
    {
        $routeName = Route::currentRouteName();
        if ($routeName === "admin.post-create") {
            $this->title = "Nowy Post";
        } elseif ($routeName === "admin.post-update") {
            $this->title = "Edytuj Post";
        }

        if ($id) {
            $this->post= BlogPost::findOrFail($id);
            $this->form->setBlogPostFormValues($this->post);
            $this->assets = $this->post->assets;
        } else {
            $this->assets = new Collection;
        }
    }

    public function save() 
    {
        if (!isset($this->post)) {
            $this->post = BlogPost::create();
            $this->form->setBlogPost($this->post);
        }
        $this->form->save();
    }

    public function saveAndClose()
    {
        $this->save();
        return $this->redirect('/admin/blog');
    }

    public function addImage()
    {
        // saving current blog, and also ensuring that blog post is set and present in database for saving assets wired to that blog post
        $this->save();
        // setting file name
        $originalFileName = $this->image->getClientOriginalName();
        $name = 'post' . $this->post->id . '_img'. count($this->assets) + 1 . '_' . $originalFileName;
        // store image on disc
        $this->image->storeAs(path: 'blog_posts_assets', name: $name, options: 'public');
        // store image data in DB
        $asset = new BlogPostAsset([
            'file_name' => $name,
            'alt_text' => $this->imageAlt,
            'source' => $this->imageSource
        ]);
        $this->post->assets()->save($asset);
        // add saved image to assets table
        $this->assets->push($asset);
        // Reset form inputs
        $this->image = null;
        $this->imageAlt = null;
        $this->imageSource = null;
    }

    protected function generateImageTag(BlogPostAsset $asset)
    {
        return "<img src=\'/storage/blog_posts_assets/{$asset->file_name}\' alt=\'{$asset->alt_text}\' class=\'w-full\' />";
    }
}; ?>

<section class="h-full">
    {{-- POST --}}
    <div class="bg-light-grey">
        <div class="area">
            <header class="flex justify-between">
                <h1 class="heading-base ml-6 sm:ml-24">{{ $title }}</h1>
                <a href="/admin/blog" class="flex gap-4 items-end text-sea-dark">
                    <span>lista postów</span>
                    <x-icon.sqr-arrow-up class="w-6 h-6"/>
                </a>
            </header>
            <hr class="my-8">
            <form class="flex flex-col gap-4" wire:submit="save">
                <div class="flex flex-col gap-2">
                    <label for="post_title" class="label">Tytuł</label>
                    <input type="text" wire:model="form.title" id="post_title" class="input-secondary">
                    @error('form.title')
                        <div class="text-orange-800">{{ $message }}</div>
                    @enderror
                </div>
                <div class="flex flex-col gap-2">
                    <label for="post_content" class="label">Treść</label>
                    <textarea rows="16" wire:model="form.content" id="post_content" class="input-secondary"></textarea>
                </div>
                <div class="flex flex-col gap-2">
                    <label for="post_excerpt" class="label">Skrót</label>
                    <textarea rows="5" wire:model="form.excerpt" id="post_excerpt" class="input-secondary"></textarea>
                </div>
                <div class="flex flex-col gap-2">
                    <label for="post_author" class="label">Autor</label>
                    <input type="text" wire:model="form.author" id="post_author" class="input-secondary">
                </div>
                <div class="flex flex-col sm:flex-row justify-between">
                    <div class="mt-8">
                        <input type="checkbox" wire:model="form.publish" id="publish">
                        <label for="publish" class="ml-4 label">
                            <span>Publikuj</span>
                            <span class="hidden lg:inline">
                                (artykuł będzie publicznie dostępny na stronie)
                            </span>
                        </label>
                    </div>
                    <div class="mt-8 self-end">
                        <button type="submit" class="btn-primary">Zapisz</button>
                        <button type="button" class="btn-secondary ml-6" wire:click="saveAndClose">
                            Zapisz i zamknij
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    {{-- ASSETS --}}
    <div class="bg-white">
        <div class="area">
            <h2 class="heading-base ml-6 sm:ml-24">Media</h2>
            <hr class="my-8">
            {{-- Uploaded assets list --}}
            <div class="flex gap-8 my-16 flex-wrap">
                @foreach ($assets as $asset)
                    <figure class="relative">
                        <img src="{{ '/storage/blog_posts_assets/' . $asset->file_name }}" alt="{{ $asset->alt_text }}" class="h-40 sm:h-50 w-40 sm:w-50 object-cover rounded-md shadow-[3px_3px_9px_#00000080]">
                        <figcaption class="text-xs sm:text-sm font-technic mt-2">
                            {{ $asset->file_name }}
                        </figcaption>
                        <div x-data="{
                            tag: '{{ $this->generateImageTag($asset) }}',
                            animation: $refs.tick.getAnimations()[0]
                            }" class="absolute bottom-9 right-2">
                            <button @click="
                                navigator.clipboard.writeText(tag);
                                if (animation) animation.play();
                            " class="block">
                                <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5.5 9H5C2.79086 9 1 10.7909 1 13V27C1 29.2091 2.79086 31 5 31H19C21.2091 31 23 29.2091 23 27V26.5" stroke="#785F5F" stroke-width="1.5" stroke-linecap="round"/>
                                    <path d="M5 30H19C20.6569 30 22 28.6569 22 27V24H13C10.2386 24 8 21.7614 8 19V10H5C3.34315 10 2 11.3431 2 13V27C2 28.6569 3.34315 30 5 30Z" fill="#ffffffb3"/>
                                    <rect x="9" y="1" width="22" height="22" rx="4" fill="#ffffffb3" stroke="#785F5F" stroke-width="1.5"/>
                                    <path d="M14 12L19 18L26 6" stroke="#785F5F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="opacity-0 origin-center animate-blink paused" x-ref="tick"/>
                                </svg>
                            </button>
                        </div>
                    </figure>
                @endforeach
            </div>
            {{-- Upload new asset form --}}
            <form wire:submit="addImage" class="flex flex-col md:flex-row gap-16">
                <div class="relative overflow-hidden border border-coffee rounded-md h-40 sm:h-50 w-40 sm:w-50">
                    <input type="file" id="media" wire:model="image" class="invisible absolute w-full">
                    <label for="media" class="flex cursor-pointer w-full h-full justify-center items-center">
                        @if ($image)
                            <img src="{{ $image->temporaryUrl() }}" alt="uploaded image file" class="w-full h-full object-cover">
                        @else
                            <x-icon.add-image/>
                        @endif
                    </label>
                </div>
                <div class="grow flex flex-col gap-3">
                    {{-- Additional image data --}}
                    <div class="grid sm:grid-cols-[5rem_1fr] gap-2 sm:gap-8 items-center">
                        <label for="img_alt" class="label">Opis</label>
                        <input type="text" id="img_alt" class="input" wire:model="imageAlt">
                    </div>
                    <div class="grid sm:grid-cols-[5rem_1fr] gap-2 sm:gap-8 items-center">
                        <label for="img_source" class="label">Źródło</label>
                        <input type="text" id="img_source" class="input" wire:model="imageSource">
                    </div>
                    {{-- Submit form --}}
                    <button type="submit" class="mt-3 md:mt-auto btn self-end">
                        Dodaj zdjęcie
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>