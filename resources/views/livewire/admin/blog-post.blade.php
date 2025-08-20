<?php
use Livewire\Attributes\{Layout, Title};
use Livewire\Volt\Component;
use App\Models\BlogPost;

new
#[Layout('components.layouts.user')]
#[Title('JDG Panel Administratora')]
class extends Component {
    public BlogPost $post;
    public function mount()
    {
        
    }
}; ?>

<div>
    //
</div>
