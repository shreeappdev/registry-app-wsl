<?php

namespace App\Livewire\Domaincancel;

use Livewire\Component;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\DB;

class DomaincancelStatus extends Component
{

    #[Title('Domain Cancel Status')]
    public function render()
    {

        $domains=DB::table('cancelletters')
        ->join('domains','domains.domainid','=','Cancelletters.domainid')
        ->join('registrant','registrant.registrantid','=','domains.registrantid')
        ->where('cancelletters.cancel_stage','<>','21')->get();

        return view('livewire.domaincancel.domaincancel-status',['domains'=>$domains]);
    }
}
