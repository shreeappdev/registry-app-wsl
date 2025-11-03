<?php

namespace App\Livewire\Backend\Subdomain\Registration;

use Illuminate\Support\Facades\Log;
use App\Helpers\Customdbresults;
use Livewire\Component;
use App\Models\Domain;
use App\Models\SubdomainFldTransactional;

class SingleSubdomainReg extends Component 
{
    public $selectedMapping;
    public $selectedDomainid;
    public $mappingType;
    public $ips = [''];
    public $selectedSigningAthority;
    public $selectedsSigningMethod;
    public $subdomainName;
    public $signingAuthority;
    public $cName;
   

    
    public function updatedSelectedDomainid($value){
       
       logger('Selected domain id:', [$this->selectedDomainid,$value]);
        $this->signingAuthority = Customdbresults::domainDetails($this->selectedDomainid,['orgContactDetails', 'adminContactDetails']);
             
    }

    public function updatedSelectedMapping($value){
        $this->mappingType = $value;
    }

     public function addIp()
    {
        if (count($this->ips) < 5) {   // max 5
           $this->ips[] = '';
        }
    }

    public function removeIp($index)
    {
        unset($this->ips[$index]);
        $this->ips = array_values($this->ips);
    }

    public function validateData()
    {               
        $rules = [
                    'selectedDomainid' => 'required',
                    'selectedSigningAthority' => 'required',
                    'selectedsSigningMethod' => 'required',
                    'selectedMapping' => 'required',
                    'subdomainName' => [
                        'required',
                        'regex:/^(?!-)(?!.*-$)(?!\.)[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)?$/'
                    ],
                    'cName' => [
                        'nullable',
                        'required_if:selectedMapping,cname',
                        'regex:/^[a-zA-Z\s]+$/',
                    ],
                ];

            if ($this->selectedMapping === 'ip') {
                $rules['ips'] = ['required', 'array'];

                foreach ($this->ips as $index => $entry) {
                    $rules["ips.$index"] = ['required', 'ip'];
                }
            }
            
            $messages =      [
                    'selectedDomainid.required' => 'this field is required',
                    'subdomainName.required' => 'this field is required',
                    'selectedSigningAthority.required' => 'this field is required',
                    'selectedsSigningMethod.required' => 'this field is required',
                    'selectedMapping.required' => 'this field is required',
                    'ips.*.required' => 'this field is required',
                    'ips.*.ip' => 'Each IP must be a valid IPv4 or IPv6 address.',                              
            ];

           $this->validate($rules,$messages );
     
    }

    public function register(){
        $this->resetErrorBag();
        $this->validateData();
        try{
        
            $domainname = Domain::where('domainid',$this->selectedDomainid)->value('domainname');
          
            SubdomainFldTransactional::create([
                'subdomainid'=> 'SUBD'.date('dmy').date('his'),
                'subdomainname' => $this->subdomainName.'.'.$domainname,
                'domainid' => $this->selectedDomainid,
                'multipleips' =>serialize($this->ips),
                'multiplecname' => serialize([$this->cName]),           
            ]);

            // generate letter
             $pdf1 = Pdf::loadView('livewire.backend.Letterformat.domainregistration-anex1', $data);
        $pdf2 = Pdf::loadView('livewire.backend.Letterformat.domainregistration-anex2', array_merge($data, $nodal_details));

        $filename1 = getAnnex1($domainDetails->domainname,$domainDetails->domainid,'reg');
        $filename2 = getAnnex2($domainDetails->domainname,$domainDetails->domainid,'reg');
        
        $path1 = storage_path("app/public/registrationletters/generated/{$filename1}");
        $pdf1->save($path1);

        $path2 = storage_path("app/public/registrationletters/generated/{$filename2}");
        $pdf2->save($path2);

        $link1 = Storage::url("registrationletters/generated/{$filename1}");
        $link2 = Storage::url("registrationletters/generated/{$filename2}");
    
        Domain::where('domainid', $this->domainid)->update(['signedby' => $this->nodalofficerid]);

        $this->dispatch('regletterGenerated', [
            'type'  => 'success',
            'title' => 'Letter Generated',
            'text'  => $domainname,
            'date'  => now()->format('Y-m-d'),
            'html'  => "<p>Annexure I and II has been generated successfully.<br>
                        <a href='{$link1}' target='_blank'>Download the Annexure I</a><br>
                        <a href='{$link2}' target='_blank'>Download the Annexure II</a>
                        </p>",
        ]);    


        }catch (\Exception $e) {
            Log::error('Transaction failed: ' . $e->getMessage());
        }       
    }

    public function getActiveDomainProperty(){
        return Domain::where('registrantid','yu7hdsy8394')
               ->where('activation_status','Active')
               ->where('lang','en')
               ->where('nic_hosting',1)
               ->get();
    }

    public function render()
    {
        return view('livewire.backend.subdomain.registration.single-subdomain-reg');
    }
}
