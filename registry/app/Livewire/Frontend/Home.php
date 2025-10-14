<?php

namespace App\Livewire\Frontend;

use App\Livewire\BaseComponent;

class Home extends BaseComponent
{
    public function render()
    {
        return $this->renderView('livewire.frontend.home', [
            'title' => 'Welcome to GOV Domain Portal',
        ]);
    }
}
