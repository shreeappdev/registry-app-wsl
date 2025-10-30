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
    public $signtype;
    public $isManual= false;

    #[Title('Domain Registration')]

    public function uploadletter(){
    
        $validated= $this->validate([
            'domainid' => 'required',
            'signtype' => 'required',
            'annex1' => 'required|mimes:pdf|max:2048',
            'annex2' => 'required|mimes:pdf|max:2048'
        ], 
        [
            'domainid.required' => 'Please choose domainname',
            'annex1.required' => 'Please select Annex-I',
            'annex2.required' => 'Please select Annex-II',
        ]);
      
        if($validated){ 
            $domainName = Domain::where('domainid', $this->domainid)->value('domainname');
            $annex1File = getAnnex1($domainName, $this->domainid , 'reg');  
            $annex2File = getAnnex2($domainName, $this->domainid , 'reg');  
   
            Authletter::updateOrCreate(
                ['domainid' => $this->domainid,'lettertype' => 1],
                ['as_reason'=> 7,'s3bucket_key'=>$annex1File]
            );
            Authletter::updateOrCreate(
                ['domainid' => $this->domainid,'lettertype' => 2],
                ['as_reason'=> 7,'s3bucket_key'=>$annex2File]
            );

            Domain::where('domainid', $this->domainid)->update(['activation_stage' => 7]);

        //     // save on storage
        //     $directory = 'public/registrationletters/uploaded';
           
        //   //  $timestamp = now()->format('Ymd_His');
        //     $filename1 =$this->domainid.'_annex1.pdf';
        //     $filename2 =$this->domainid.'_annex2.pdf';

            // Store files in storage/app/public/registrationletters/
            $this->annex1->storeAs('public/registrationletters/uploaded', $annex1File);
            $this->annex2->storeAs('public/registrationletters/uploaded', $annex2File);

            session()->flash('message', 'Letters are uploaded and request is submitted successfully');
            return redirect(route('domain_status'));
        
        }else{
            session()->flash('error', 'Letters are uploaded and request is submitted successfully'); 
        }
        
    }

    public function updatedSigntype(){
        $this->isManual = $this->signtype == 'manual'? true : false;
    }
    public function getGeneratedLtrProperty()
    {
        return Domain::where('activation_status', 'Pending')
            ->where('registrantid', $this->userId)
            ->whereIn('activation_stage', [1,7, 15, 16])
            ->where('signedby', '!=', 0)
            ->get();
    }

    // public function updated($propertyName){
    //     $this->resetErrorBag($propertyName);
    // }

    public function render()
    {
        return view('livewire.backend.domainregistration.submit-registration-letter');
    }
}
