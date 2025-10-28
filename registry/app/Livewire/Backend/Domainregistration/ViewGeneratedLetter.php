<?php

namespace App\Livewire\Backend\Domainregistration;

use Livewire\Component;
use App\Models\Domain;


class ViewGeneratedLetter extends Component
{
    public $userId = 'yu7hdsy8394';
    public function getGeneratedLtrProperty()
    {
        return Domain::where('activation_status', 'Pending')
            ->where('registrantid',$this->userId)
            ->where('activation_stage', 1)
            ->where('signedby', '!=', 0)
            ->get();
    }

    public function render()
    {
        return view('livewire.backend.domainregistration.view-generated-letter');
    }

}
