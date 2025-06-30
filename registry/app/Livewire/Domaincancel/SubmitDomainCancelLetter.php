<?php

namespace App\Livewire\Domaincancel;

use App\Models\Domain;
use Livewire\Component;
use App\Models\Cancelletters;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Storage;

class SubmitDomainCancelLetter extends Component
{

    use WithFileUploads;

    public $domainid;
    public $file;
    public $remarks;
    
    #[Title('Domain Cancel')]
    public function submitCancelLetter(){
       
        $validated= $this->validate([
            'domainid' => 'required',
            'file' => 'required|mimes:pdf|max:2048',
        ], 
        [
            'domainid.required' => 'Please choose domainname',
            'file.required' =>'Please upload the letter',

        ]);

    
        if($validated){

            $domaindetails= Domain::where('domainid','=',$this->domainid)->first();
             $is_insert = Cancelletters::updateOrCreate(
                ['domainid' => $domaindetails->domainid],
                ['al_remarks' => $this->remarks]
            );

        
            //session()->flash('message', 'Letter is uploaded and request is submitted successfully'); 
            return redirect()->route('submitletter_domaincancel')->with('success', 'Letter is uploaded and request is submitted successfully')->with('formSubmitted', true);

           
        }else{

            return redirect()->route('submitletter_domaincancel')->with('error', 'Letters are uploaded and request is submitted successfully');
            // //session()->flash('error', 'Letters are uploaded and request is submitted successfully'); 
        }

    }
   
    public function render()
    {   $domains=Domain::where('registrantid','yu7hdsy8394')->get();
        return view('livewire.domaincancel.submit-domain-cancel-letter',['domains'=>$domains]);
    }
}
