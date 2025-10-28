<?php

namespace App\Livewire\Backend\Domainregistration;

use App\Models\Domain;
use Livewire\Component;
use App\Models\Authletter;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;

class SubmitRegistrationLetter extends Component
{

    use WithFileUploads;
    public $userId = 'yu7hdsy8394';
    public $domainid;
    public $lettertype;
    public $annex1;
    public $annex2;

    #[Title('Domain Registration')]

    public function uploadletter(){
        
        $validated= $this->validate([
            'domainid' => 'required',
            'annex1' => 'required|mimes:pdf|max:2048',
            'annex2' => 'required|mimes:pdf|max:2048'
        ], 
        [
            'domainid.required' => 'Please choose domainname',
            'annex1.required' => 'Please select Annex-I',
            'annex2.required' => 'Please select Annex-II',
        ]);
       
        if($validated){      
               
            Authletter::updateOrCreate(
                ['domainid' => $this->domainid,'lettertype' => 1],
                ['as_reason'=> 7,'esign'=>0]
            );
            Authletter::updateOrCreate(
                ['domainid' => $this->domainid,'lettertype' => 2],
                ['as_reason'=> 7,'esign'=>0]
            );

            Domain::where('domainid', $this->domainid)->update(['activation_stage' => 7]);

        //     // save on storage
        //     $directory = 'public/registrationletters/uploaded';
           
        //   //  $timestamp = now()->format('Ymd_His');
        //     $filename1 =$this->domainid.'_annex1.pdf';
        //     $filename2 =$this->domainid.'_annex2.pdf';

            // Store files in storage/app/public/registrationletters/
            $this->annex1->storeAs('public/registrationletters/uploaded', $this->domainid.'_annex1.pdf');
            $this->annex2->storeAs('public/registrationletters/uploaded', $this->domainid.'_annex2.pdf');

            session()->flash('message', 'Letters are uploaded and request is submitted successfully');
            return redirect(route('domain_status'));
        
        }else{
            session()->flash('error', 'Letters are uploaded and request is submitted successfully'); 
        }
        
    }

    public function getGeneratedLtrProperty()
    {
        return Domain::where('activation_status', 'Pending')
            ->where('registrantid', $this->userId)
            ->whereIn('activation_stage', [1,7, 15, 16])
            ->where('signedby', '!=', 0)
            ->get();
    }


    public function render()
    {
        return view('livewire.backend.domainregistration.submit-registration-letter');
    }
}
