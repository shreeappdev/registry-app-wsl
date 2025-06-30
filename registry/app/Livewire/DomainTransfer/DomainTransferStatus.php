<?php

namespace App\Livewire\DomainTransfer;

use Livewire\Component;
use Livewire\Attributes\Title;
use App\Models\DomainDlgLetter;

class DomainTransferStatus extends Component
{

    #[Title('Domain Transfer')]
    public function render()
    {

        $allrequests= DomainDlgLetter::all();
        return view('livewire.domain-transfer.domain-transfer-status',['allrequests'=>$allrequests]);
    }
}
