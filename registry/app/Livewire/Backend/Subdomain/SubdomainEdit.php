<?php

namespace App\Livewire\Backend\Subdomain;

use Livewire\Component;
use Livewire\Attributes\Title;

class SubdomainEdit extends Component
{
    #[Title('Update Subdomain')]
    public function updateSubdomain(){

        
    }
    public function render()
    {
        return view('livewire.backend.subdomain.subdomain-edit');
    }
}
