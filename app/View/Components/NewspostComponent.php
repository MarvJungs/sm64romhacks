<?php

namespace App\View\Components;

use App\Models\Newspost;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class NewspostComponent extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public Newspost $newspost)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.newspost');
    }
}
