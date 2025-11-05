<?php
use Livewire\Attributes\{Layout, Title};
use Livewire\Volt\Component;
use App\Models\BlogPost;

new
#[Layout('components.layouts.admin')]
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
