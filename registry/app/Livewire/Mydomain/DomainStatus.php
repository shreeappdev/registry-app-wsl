<?php

namespace App\Livewire\Mydomain;

use App\Models\Domain;
use Livewire\Component;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\DB;

class DomainStatus extends Component
{

    #[Title('Domain Status')]
    public function render()
    {

        $domains=Domain::with(['registrationLetters.asReason'])
                ->where('activation_status','Pending')
                ->get();

              
              
         return view('livewire.mydomain.domain-status',['domains'=>$domains]);
    }
}
