<?php

namespace App\Livewire\Backend\Subdomain;

use Livewire\Component;
use Livewire\Attributes\Title;

class SubdomainDeactivate extends Component
{
    #[Title('Deactivate Subdomain')]
    public function deletesubdomain(){
        
    }
    public function render()
    {
        return view('livewire.backend.subdomain.subdomain-deactivate');
    }
}
