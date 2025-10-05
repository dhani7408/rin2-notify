<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SidebarLayout extends Component
{
    public $headerTitle;
    public $headerDescription;

    /**
     * Create a new component instance.
     */
    public function __construct($headerTitle = null, $headerDescription = null)
    {
        $this->headerTitle = $headerTitle;
        $this->headerDescription = $headerDescription;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.sidebar-layout');
    }
}
