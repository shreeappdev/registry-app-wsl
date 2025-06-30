<?php

namespace App\Livewire\Subdomain;

use Livewire\Component;
use Livewire\Attributes\Title;

class SubdomainEdit extends Component
{
    #[Title('Update Subdomain')]
    public function updateSubdomain(){

        
    }
    public function render()
    {
        return view('livewire.subdomain.subdomain-edit');
    }
}
