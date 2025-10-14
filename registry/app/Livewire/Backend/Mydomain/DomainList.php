<?php

namespace App\Livewire\Mydomain;

use App\Models\Domain;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithPagination;
class DomainList extends Component
{

    use WithPagination;

    #[Title('Domain Details')]
    public function render()
    {

        $domains=Domain::where('registrantid','yu7hdsy8394')->paginate(10);

        return view('livewire.mydomain.domain-list',['domains'=> $domains]);
    }
}
