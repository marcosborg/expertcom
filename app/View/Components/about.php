<?php

namespace App\View\Components;

use Illuminate\View\Component;

class about extends Component
{

    private $sobre;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->sobre = \App\Models\HomeInfo::first();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {

        print_r($this->sobre);

        return view('components.about')->with('sobre', $this->sobre);
    }
}
