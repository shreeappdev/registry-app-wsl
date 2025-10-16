<?php

namespace App\Livewire\Backend;

use Livewire\Component;
use Livewire\Attributes\Title;

class Dashboard extends Component
{

    #[Title('Dashboard')]
    public function render()
    {
        return view('livewire.backend.dashboard');
    }
}

// to be used
// namespace App\Livewire\Backend;

// use App\Livewire\BaseComponent;

// class Dashboard extends BaseComponent
// {
//     public function render()
//     {
//         return $this->renderView('livewire.backend.dashboard', [
//             'user' => auth()->user(),
//             'title' => 'Dashboard',
//         ]);
//     }
// }

