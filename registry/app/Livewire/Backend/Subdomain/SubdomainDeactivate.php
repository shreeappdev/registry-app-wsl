<?php

namespace App\Livewire\Subdomain;

use Livewire\Component;
use Livewire\Attributes\Title;

class SubdomainDeactivate extends Component
{
    #[Title('Deactivate Subdomain')]
    public function deletesubdomain(){
        
    }
    public function render()
    {
        return view('livewire.subdomain.subdomain-deactivate');
    }
}
