<?php

namespace App\View\Components\Romhack;

use App\Models\Romhack;
use App\Models\Version;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

class VersionsTable extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public Romhack $hack, public Collection $versions)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.romhack.versions-table');
    }
}
