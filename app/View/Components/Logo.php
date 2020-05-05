<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Logo extends Component
{
    public $prefix;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $prefix)
    {
        $this->prefix = $prefix;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.logo');
    }
}
