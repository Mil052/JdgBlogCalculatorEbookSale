<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;
use App\Models\BlogPost;

class BlogPostForm extends Form
{
    public ?BlogPost $post;

    #[Validate('required|min:12')]
    public $title;

    public $excerpt;

    public $content;

    public $author;

    public $publish = false;

    public function setBlogPostFormValues(BlogPost $post)
    {
        $this->post = $post;
        $this->title = $post->title;
        $this->excerpt = $post->excerpt;
        $this->content = $post->content;
        $this->author = $post->author;
        $this->publish = $post->publish;
    }

    public function setBlogPost(BlogPost $post)
    {
        $this->post = $post;
    }

    public function save()
    {
        $this->validate();
        $this->post->update($this->only(['title', 'excerpt', 'content', 'author', 'publish' ]));
    }
}
