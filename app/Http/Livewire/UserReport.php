<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
class UserReport extends Component
{
    public $from,$to;
    public function render()
    {
        $users = User::whereHas('purchases', function($query)
        {
            $query->whereBetween('created_at', [$this->from, $this->to]);

        })->get();
        return view('livewire.user-report', compact('users'));
    }
}
