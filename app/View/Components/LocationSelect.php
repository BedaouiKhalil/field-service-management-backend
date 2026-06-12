<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;

class LocationSelect extends Component
{
    public function __construct(
        public Collection $wilayas,
        public ?int $selectedWilaya = null,
        public ?int $selectedCommune = null
    ) {}

    public function render(): View
    {
        return view('components.location-select');
    }
}
