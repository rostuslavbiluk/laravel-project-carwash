<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ArticlesShow extends Component
{
    public $content;
    public $title;

    /**
     * Articles constructor.
     *
     * @param string $content
     * @param string $title
     */
    public function __construct(string $title, string $content)
    {
        $this->title = $title;
        $this->content = $content;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.articles.show');
    }
}
