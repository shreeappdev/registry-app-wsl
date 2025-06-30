<?php

namespace App\Livewire\Mydomain;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Title;

class ContactUpdateStatus extends Component
{

    #[Title('Contact Update Status')]
    public function render()
    {

        $contactdata=DB::table('mod_contacts')
        ->join('domains','domains.domainid','=','mod_contacts.domainid')
        ->select('mod_contacts.*','domains.domainname')
        ->where('mod_contacts.registrantid','')
        ->where('approved','P')->get();

      
        return view('livewire.mydomain.contact-update-status',['contactdata'=>$contactdata]);
    }
}
