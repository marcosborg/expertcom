<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\HeroBanner;

class hero extends Component
{

    private $hero;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->hero = HeroBanner::first();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.hero')->with('hero', $this->hero);
    }
}
