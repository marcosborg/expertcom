<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\FaqQuestion;

class FaqsComponent extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    private $faq_questions;

    public function __construct()
    {
        $this->faq_questions = FaqQuestion::all()->load('category');
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.faqs-component')->with('faq_questions', $this->faq_questions);
    }
}
