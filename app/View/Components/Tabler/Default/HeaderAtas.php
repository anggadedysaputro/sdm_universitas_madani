<?php

namespace App\View\Components\Tabler\Default;

use App\Models\Applications\Config;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class HeaderAtas extends Component
{
    public string $logo;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->logo = $this->getLogo();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.tabler.default.header-atas');
    }

    public function getLogo()
    {
        $getLogo = Config::where('key', 'logo')->get();
        $logo = "";
        if (!$getLogo->isEmpty()) $logo = str_replace("public/", "", $getLogo[0]->value);

        return $logo;
    }
}
