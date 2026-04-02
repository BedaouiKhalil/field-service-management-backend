<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;

class LocationSelector extends Component
{
    public function __construct(
        public Collection $wilayas,
        public ?int $selectedWilaya = null,
        public ?int $selectedCommune = null
    ) {}

    public function render(): View
    {
        return view('components.form.location-selector');
    }
}
