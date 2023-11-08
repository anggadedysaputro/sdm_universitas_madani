<?php

namespace App\View\Components\Tabler\Default;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PageWrapperBody extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.tabler.default.page-wrapper-body');
    }
}
