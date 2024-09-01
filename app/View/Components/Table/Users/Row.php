<?php

namespace App\View\Components\Table\Users;

use App\Models\User;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Row extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public User $user, public array $roles)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.table.users.row');
    }
}
