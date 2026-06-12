<?php

namespace App\View\Components;

use App\Models\User;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class UserSelect extends Component
{
    public $selectedUser = null;

    public function __construct(
        public $users = [],
        public $roleName = null,
        public $label = null,
        public $selected = null,
        public $name = 'user_id',
    ) {
        if ($this->selected) {
            if (!empty($this->users)) {
                $this->selectedUser = collect($this->users)->firstWhere('id', $this->selected);
            } else {
                $this->selectedUser = User::find($this->selected);
            }
        }
    }

    public function render(): View|Closure|string
    {
        return view('components.user-select');
    }
}
