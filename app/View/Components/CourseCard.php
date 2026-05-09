<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CourseCard extends Component
{
    /**
     * Create a new component instance.
     */
    public $title, $image, $price, $link;

    public function __construct($title, $image, $price, $link)
    {
        $this->title = $title;
        $this->image = $image;
        $this->price = $price;
        $this->link = $link;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.test_taker.course-card');
    }
}
