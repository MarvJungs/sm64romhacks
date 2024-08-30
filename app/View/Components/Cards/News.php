<?php

namespace App\View\Components\Cards;

use App\Models\News as ModelsNews;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class News extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public ModelsNews $message)
    {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.cards.news');
    }
}
