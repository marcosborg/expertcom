<?php

namespace App\View\Components;

use Illuminate\View\Component;

class about extends Component
{

    private $about;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->about = \App\Models\HomeInfo::first();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.about')->with('about', $this->about);
    }
}
