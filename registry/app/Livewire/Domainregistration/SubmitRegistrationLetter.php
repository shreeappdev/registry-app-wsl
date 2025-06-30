<?php

namespace App\Livewire\Domainregistration;

use App\Models\Domain;
use Livewire\Component;
use App\Models\Authletter;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;

class SubmitRegistrationLetter extends Component
{

    use WithFileUploads;

    public $domainid;
    public $lettertype;
    public $anex1;
    public $anex2;

    #[Title('Domain Registration')]

    public function uploadletter(){
        
        $validated= $this->validate([
            'domainid' => 'required',
            // 'anex1' => 'required|mimes:pdf|max:2048',
            // 'anex2' => 'required|mimes:pdf|max:2048'
        ], 
        [
            'domainid.required' => 'Please choose domainname',
            // 'anex1.required' => 'Please select Annx-I',
            // 'anex2.required' => 'Please select Annx-II',
        ]);

        if($validated){
        
            $reglettersinsert = Authletter::updateOrCreate(
                ['domainid' => $this->domainid,'lettertype' => 1],
                ['file_name' => "new",'as_remark'=>"sss"]
            );
            session()->flash('message', 'Letters are uploaded and request is submitted successfully');
            return redirect(route('domain_status'));
        
        }else{
            session()->flash('error', 'Letters are uploaded and request is submitted successfully'); 
        }
        
    }
    public function render()
    {

        $domains = Domain::all();
        return view('livewire.domainregistration.submit-registration-letter',['domains'=> $domains]);
    }
}
