<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\FormName;

class ContactComponent extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    private $forms;

    public function __construct()
    {
        $this->forms = FormName::whereHas('roles', function ($roles) {
            $roles->where('title', 'User');
        })->get()->load('roles', 'form_inputs');
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.contact-component')->with([
            'forms' => $this->forms
        ]);
    }
}
