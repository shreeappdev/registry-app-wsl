<?php

namespace App\Livewire\Backend\Subdomain\SubmitLetter;

use Livewire\Component;
use App\Models\Domain;
use App\Models\SubdoamainCurrentIp;
use App\Models\Subdomain;
use App\Models\SubdomainFldTransactional;
use App\Models\SubdomainLetter;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;



class SingleSubdomainSubmitLetter extends Component
{
    use WithFileUploads;
    public $selectedDomainid;
    public $selectedSubdomain;
    public $letter;
    public $subdomains;
    public $userId = 'yu7hdsy8394';

    public function uploadletter(){

        $this->validate([
            'selectedDomainid' => 'required',
            'selectedSubdomain' => 'required',
            'letter' => 'required|mimes:pdf|max:2048',
            
        ], 
        [
            'domainid.required' => 'Please choose domainname',
            'letter.required' => 'Please upload letter',
        ]);
      
        try{        
            $subdomain = SubdomainFldTransactional::where('subdomainid', $this->selectedSubdomain)->first();
            
            if(!empty($subdomain)){
                $filename = letterName($subdomain->subdomainname,$subdomain->subdomainid,'sub_reg');
                DB::transaction(function () use ($subdomain, $filename) {
                    
                    SubdomainFldTransactional::where('subdomainid', $subdomain->subdomainid)
                        ->update(['status'=>'uploaded']);

                    Subdomain::create([
                        'subdomainid'=>$subdomain->subdomainid,
                        'domainid'=>$subdomain->domainid,
                        'domainname'=>implode('.', array_slice(explode('.', $subdomain->subdomainname), -3)),
                        'subdomainname'=>$subdomain->subdomainname,
                        'registrantid'=>$this->userId,
                        'registrationdate'=>$subdomain->createdon,
                        'lastupd_date'=>now(),
                        'multipleips'=>$subdomain->multipleips,
                        'multiplecname'=>$subdomain->multiplecname,
                        'activation_status' => 'Pending',
                    ]);

                    SubdoamainCurrentIp::create([
                        'domainid' => $subdomain->domainid,
                        'subdomainid'=>$subdomain->subdomainid,
                        'multipleips'=>$subdomain->multipleips,
                        'multiplecname'=>$subdomain->multiplecname,
                    ]);

                    SubdomainLetter::create([
                        'subdomainid'=>$subdomain->subdomainid,
                        'subdomainname'=>$subdomain->subdomainname,
                        's3bucket_key'=>$filename
                    ]);

                });
                
                $this->letter->storeAs('public/registrationletters/uploaded', $filename);
                session()->flash('message', 'Letters are uploaded and request is submitted successfully');
                return redirect(route('domain_status'));
            }
        }catch(\Exception  $e){
            
            Log::error('Transaction failed: ' . $e->getMessage());
        }
        //  if($validated){ 
                        
         
   
        //     Authletter::updateOrCreate(
        //         ['domainid' => $this->domainid,'lettertype' => 1],
        //         ['as_reason'=> 7,'s3bucket_key'=>$annex1File]
        //     );
        //     Authletter::updateOrCreate(
        //         ['domainid' => $this->domainid,'lettertype' => 2],
        //         ['as_reason'=> 7,'s3bucket_key'=>$annex2File]
        //     );

        //     Domain::where('domainid', $this->domainid)->update(['activation_stage' => 7]);

        //     $this->annex1->storeAs('public/registrationletters/uploaded', $annex1File);
        //     $this->annex2->storeAs('public/registrationletters/uploaded', $annex2File);

        //     session()->flash('message', 'Letters are uploaded and request is submitted successfully');
        //     return redirect(route('domain_status'));
        
        // }else{
        //     session()->flash('error', 'Letters are uploaded and request is submitted successfully'); 
        // }
        
    }

    public function updatedSelectedDomainid($value){
        $this->subdomains =  SubdomainFldTransactional::where('domainid',$value)
            ->where('status','generated')
            ->where('request_type','registration')
            ->get();
            //dd($this->subdomains);

    }

    public function getActiveDomainProperty()
    {
        return Domain::where('registrantid','yu7hdsy8394')
               ->where('activation_status','Active')
               ->where('lang','en')
               ->where('nic_hosting',1)
               ->get();
    }

    public function render()
    {
        return view('livewire.backend.subdomain.submit-letter.single-subdomain-submit-letter');
    }
}
