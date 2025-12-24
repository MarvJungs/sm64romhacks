<?php

namespace App\View\Components\Moderation;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Sidebar extends Component
{
    public array $sections;
    /**
     * Create a new component instance.
     */
    public function __construct(array $sections = null)
    {
        $this->sections = ['authors', 'comments', 'roles', 'romhacktags', 'users'];
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.moderation.sidebar');
    }
}
