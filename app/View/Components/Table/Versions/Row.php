<?php

namespace App\View\Components\Table\Versions;

use App\Models\Version;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Row extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public Version $version)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.table.versions.row');
    }
}
