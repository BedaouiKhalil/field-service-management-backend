<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class RoleSelect extends Component
{
    /**
     * Create a new component instance.
     */
    public $roles;
    public $selected;

    public function __construct($roles, $selected = null)
    {
        $this->roles = $roles;
        $this->selected = $selected;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.role-select');
    }
}
