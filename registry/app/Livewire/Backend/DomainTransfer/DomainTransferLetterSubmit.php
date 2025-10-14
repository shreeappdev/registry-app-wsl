<?php

namespace App\Livewire\DomainTransfer;

use Livewire\Component;
use Livewire\Attributes\Title;
use App\Models\DomainDlgLetter;

class DomainTransferLetterSubmit extends Component
{
    
    #[Title('Domain Transfer')]
    public function submittransferLetter(){
        
    }
    public function render()
    {
        $generatedLetters= DomainDlgLetter::where(['applystatus'=>'Pending','registrantid'=>'yu756sy8309'])->get();
        return view('livewire.domain-transfer.domain-transfer-letter-submit',['generatedLetters'=>$generatedLetters]);
    }
}
