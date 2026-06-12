<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Customer;

class CustomerSelect extends Component
{
    public $selectedCustomer = null;

    /**
     * Create a new component instance.
     */
    public function __construct(
        public $customers = [],
        public $selected = null,
        public $showLabel = true,
    ) {
        if ($this->selected) {
            if (!empty($this->customers)) {
                $this->selectedCustomer = collect($this->customers)->firstWhere('id', $this->selected);
            } else {
                $this->selectedCustomer = Customer::find($this->selected);
            }
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.customer-select');
    }
}
