<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Http;
class MarathonSchedule extends Component
{
    public $schedules;
    public $error;
    /**
     * Create a new component instance.
     */
    public function __construct(string $slug)
    {
        $request = Http::get("https://horaro.org/-/api/v1/events/$slug/schedules");
        $this->schedules = $request->json();
        $this->error = !$request->successful();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.marathon-schedule');
    }
}
