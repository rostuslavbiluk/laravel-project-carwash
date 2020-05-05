<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ArticlesMini extends Component
{
    public $title;
    public $code;
    public $content;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($title, $code, $content)
    {
        $this->title = $title;
        $this->code = $code;
        $this->content = $content;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.articles.mini');
    }
}
