<?php

namespace App\Livewire\Backend\Subdomain\Registration;

use Livewire\Component;
use App\Helpers\Customdbresults;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use App\Models\SubdomainFldTransactional;
use App\Models\Domain;
use App\Models\Contact;
// use Illuminate\Support\Str;

class MultiSubdomainReg extends Component
{
    public $totalStep=11;
    public $currentStep=1;
    public $signingAuthority;
    public $selectedDomainid;
    public $selectedSigningAthority;
    public $selectedsSigningMethod;
    public $subdomainName;
    public $selectedMapping;
    public $mappingType;
    public $ips = [''];
    public $cName;
    public $keepSameMapping;
    public $isSameMapping= false;
    public $multiSubDomainName =[''];
    public $stepsData = [];
 
    // public function mount()
    // {
    //     // Initialize 10 steps (you can also create dynamically)
    //     for ($i = 2; $i < 12; $i++) {
    //         $this->stepsData[$i] = [
    //             'subdomain' => '',
    //           //  'mapping' => '',
    //             'cName' => '',
    //             'ips' => [''],
    //         ];
    //     }
    // }

    public function increaseStep(){ 
       // dd('SUBD' .date('dmy'). bin2hex(random_bytes(8)));

        $this->resetErrorBag();
        $this->validateData();  

        $this->currentStep++;
        if($this->currentStep > $this->totalStep){
            $this->currentStep = $this->totalStep;
        } 
        $this->selectedMapping = '';
        $this->mappingType = '';
    }

    public function decreaseStep(){
        $this->resetErrorBag();
        $this->currentStep--;
        if($this->currentStep < 1){
            $this->currentStep = 1;
        }
    }
    
    public function addEntry($entry)
    {
       
        if ($entry == 'ip' && count($this->ips) < 5) {   // max 5
           $this->ips[] = '';
        }elseif($entry == 'subdomain' && count($this->multiSubDomainName) < 10){
            $this->multiSubDomainName[] = '';
        }elseif($entry == 'stepsip'){
            if (!isset($this->stepsData[$this->currentStep])) {
                $this->stepsData[$this->currentStep] = ['ips' => ['']];
            }

            if (!isset($this->stepsData[$this->currentStep]['ips']) || !is_array($this->stepsData[$this->currentStep]['ips'])) {
                $this->stepsData[$this->currentStep]['ips'] = [''];
            }

            if (count($this->stepsData[$this->currentStep]['ips']) < 5) {
                $this->stepsData[$this->currentStep]['ips'][] = '';
            }
        }
    }

    public function removeEntry($entry,$index)
    {
        if($entry == 'ip'){
            unset($this->ips[$index]);
            $this->ips = array_values($this->ips);
        }elseif($entry == 'subdomain'){
            unset($this->multiSubDomainName[$index]);
            $this->multiSubDomainName = array_values($this->multiSubDomainName);
        }elseif($entry == 'stepsip'){
            unset($this->stepsData[$this->currentStep]['ips'][$index]);
            $this->stepsData[$this->currentStep]['ips'] = array_values($this->stepsData[$this->currentStep]['ips']);
        }
        
    }

    // public function validateData1()
    // {

    //     $rules = [];
    //     $messages = [];

    //     if ($this->currentStep == 1) {
    //         $rules = [
    //             'selectedDomainid' => 'required',
    //             'selectedSigningAthority' => 'required',
    //             'selectedsSigningMethod' => 'required'
    //         ];
    //         $messages = [
    //             'selectedDomainid.required' => 'This field is required.',
    //             'selectedSigningAthority.required' => 'This field is required.',
    //             'selectedsSigningMethod.required' => 'This field is required.'
    //         ];
    //     }

    //     if ( !($this->isSameMapping) && $this->currentStep > 1 && $this->currentStep <= $this->totalStep ) {
    //         $rules = [
    //             'selectedMapping' => 'required',
    //             'cName' => [
    //                 'nullable',
    //                 'required_if:selectedMapping,cname',
    //                 'regex:/^[a-zA-Z\s]+$/',
    //             ],
    //         ];

    //         if ($this->selectedMapping === 'ip') {
    //             $this->ips = array_map('trim', $this->ips);
    //             $rules['ips'] = ['required', 'array'];
    //             $rules['ips.*'] = ['required', 'ip', 'distinct'];
    //         }

    //         $this->multiSubDomainName = array_map('trim', $this->multiSubDomainName);
    //         $rules['multiSubDomainName'] = ['required', 'array'];
    //         $rules['multiSubDomainName.*'] = [
    //             'required',
    //             'distinct',
    //             'regex:/^(?!-)(?!.*-$)(?!\.)[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)?$/',
    //         ];
         
    //         $messages = array_merge($messages, [
    //             'selectedMapping.required' => 'This field is required.',
    //             'ips.*.required' => 'This field is required.',
    //             'ips.*.ip' => 'Each IP must be a valid IPv4 or IPv6 address.',
    //             'ips.*.distinct' => 'Duplicate IP addresses are not allowed.',
    //             'multiSubDomainName.*.required' => 'This field is required.',
    //             'multiSubDomainName.*.regex' => 'Enter a valid subdomain (e.g., "abc" or "abc.xyz").',
    //             'multiSubDomainName.*.distinct' => 'Duplicate subdomain names are not allowed.',
    //         ]);
    //     }

    //     $this->validate($rules, $messages);
    // }

    public function validateData()
    {
        
        if($this->currentStep == 1){
            $this->validate($this->rulesForStep1(), $this->messagesForStep1());
        }elseif($this->isSameMapping){
            $this->validate($this->rulesForSameMapping(), $this->messagesForSameMapping());                
        }else{
            $this->validate($this->rules(), $this->messages());                
        }

        if ($this->currentStep > 1 && !isset($this->stepsData[$this->currentStep])) {
            $this->stepsData[$this->currentStep] = [
                'subdomain' => '',
                'cName' => '',
                'ips' => [''],
            ];
        }
    }
    
    // public function validateCurrentStep()
    // {
    //     $index = $this->currentStep - 1;

    //     $rules = [
    //         "stepsData.$index.subdomain" => [
    //             'required',
    //             'regex:/^(?!-)(?!.*-$)(?!\.)[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)?$/'
    //         ],
    //         "stepsData.$index.mapping" => 'required|in:cname,ip',
    //         "stepsData.$index.cname" => 'required_if:stepsData.' . $index . '.mapping,cname|nullable|regex:/^[a-zA-Z0-9\.\-]+$/',
    //         "stepsData.$index.ips" => 'required_if:stepsData.' . $index . '.mapping,ip|array',
    //         "stepsData.$index.ips.*" => 'required_if:stepsData.' . $index . '.mapping,ip|ip|distinct',
    //     ];

    //     $messages = [
    //         "stepsData.$index.subdomain.required" => "Subdomain is required for step " . ($index + 1),
    //         "stepsData.$index.mapping.required" => "Mapping is required for step " . ($index + 1),
    //         "stepsData.$index.ips.*.ip" => "Each IP must be valid",
    //     ];

    //     $this->validate($rules, $messages);
    // }

    private function rules(){
        return [
            "selectedMapping" => "required",
            "stepsData.*.subdomain" => [
                'required',
                'regex:/^(?!-)(?!.*-$)(?!\.)[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)?$/',
                'distinct'
            ],
          //  "stepsData.$this->currentStep.mapping" => 'required|in:cname,ip',
            // "stepsData.$this->currentStep.cName" => 'required_if:stepsData.' . $this->currentStep . '.mapping,cname|nullable|regex:/^[a-zA-Z0-9\.\-]+$/',
            "stepsData.$this->currentStep.cName" => 'required_if:selectedMapping,cname|nullable|regex:/^[a-zA-Z0-9\.\-]+$/',
            // "stepsData.$this->currentStep.ips" => 'required_if:stepsData.' . $this->currentStep . '.mapping,ip|array',
            // "stepsData.$this->currentStep.ips.*" => 'required_if:stepsData.' . $this->currentStep . '.mapping,ip|ip|distinct',
            "stepsData.$this->currentStep.ips" => 'required_if:selectedMapping,ip|array',
            "stepsData.$this->currentStep.ips.*" => 'required_if:selectedMapping,ip|ip|distinct',
        ];
    }

    private function messages(){
        return [
            "selectedMapping.required" => "This field is required.",
            "stepsData.*.subdomain.required" => "This field is required.",
            "stepsData.*.subdomain.distinct" => "Duplicate subdomain.",
           // "stepsData.$this->currentStep.mapping.required" => "Mapping is required for step " . $this->currentStep,
            "stepsData.$this->currentStep.cName.required_if" => "This field is required.",
            "stepsData.$this->currentStep.cName.regex" => 'CNAME may only contain letters and spaces.',
            "stepsData.$this->currentStep.ips.*.required_if" => "This field is required.",
            "stepsData.$this->currentStep.ips.*.ip" => "Each IP must be a valid IPv4 or IPv6 address.",
            "stepsData.$this->currentStep.ips.*.distinct" => "Duplicate IP addresses are not allowed.",
        ];

    }

    private function rulesForSameMapping()
    {
        $rules = [
                'selectedMapping' => 'required',
                'cName' => [
                    'nullable',
                    'required_if:selectedMapping,cname',
                    'regex:/^[a-zA-Z\s]+$/',
                ],
                'multiSubDomainName' => ['required', 'array'],
                'multiSubDomainName.*' => [
                    'required',
                    'distinct',
                    'regex:/^(?!-)(?!.*-$)(?!\.)[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)?$/',
                ],
            ];

            if ($this->selectedMapping === 'ip') {
                $this->ips = array_map('trim', $this->ips);
                $rules['ips'] = ['required', 'array'];
                $rules['ips.*'] = ['required', 'ip', 'distinct'];
            }
            $this->multiSubDomainName = array_map('trim', $this->multiSubDomainName);  

        return $rules;      
    }

    private function messagesForSameMapping(){
        $messages =  [
                'selectedMapping.required' => 'This field is required.',
                'cName.required_if' => 'This field is required.',
                'cName.regex' => 'CNAME may only contain letters and spaces.',
                'ips.*.required' => 'This field is required.',
                'ips.*.ip' => 'Each IP must be a valid IPv4 or IPv6 address.',
                'ips.*.distinct' => 'Duplicate IP addresses are not allowed.',
                'multiSubDomainName.*.required' => 'This field is required.',
                'multiSubDomainName.*.regex' => 'Enter a valid subdomain (e.g., "abc" or "abc.xyz").',
                'multiSubDomainName.*.distinct' => 'Duplicate subdomain names are not allowed.',
        ];

        return $messages;
    }

    private function rulesForStep1(){
        return [
                'selectedDomainid' => 'required',
                'selectedSigningAthority' => 'required',
                'selectedsSigningMethod' => 'required'
            ];
    }

    private function messagesForStep1(){
        return [
                'selectedDomainid.required' => 'This field is required.',
                'selectedSigningAthority.required' => 'This field is required.',
                'selectedsSigningMethod.required' => 'This field is required.'
            ];
    }

    public function updatedKeepSameMapping($value){
        $this->isSameMapping = $value;
    }

    public function updatedSelectedMapping($value){
        $this->mappingType = $value;
    }

    public function updatedSelectedDomainid($value){
        $this->signingAuthority = Customdbresults::domainDetails($value,['orgContactDetails', 'adminContactDetails']);           
    }

    public function register()
    {
       
        $this->resetErrorBag();
        $this->validateData();
        //dd($this->multiSubDomainName,$this->ips, $this->cName);
        // dd($this->currentStep,$this->stepsData);
        try{
            // if($this->isSameMapping){
            //     SubdomainFldTransactional::
            // }

            // $subdomainid = 'SUBD'.date('dmy').date('his');

            // $subdomainid = 'SUBD-' . Str::ulid();
            $domainname = Domain::where('domainid',$this->selectedDomainid)->value('domainname');
            $authorityDetails = Contact::selectedDetails($this->selectedSigningAthority);
            $subdomainname = $this->subdomainName.'.'.$domainname;

            // check,  Is subdomain already exist
            $exists = SubdomainFldTransactional::where('subdomainname', $subdomainname)->exists();
            if ($exists) {
                return $this->addError('subdomainName', 'This subdomain already exists.');
            }
            if(!($this->isSameMapping) && !empty($this->stepsData)){
                foreach($this->stepsData as $key => $value){
                  //  $subdomainid = 'SUBD' .date('dmy'). bin2hex(random_bytes(8));
                   $subdomainname = !empty($value['subdomain'])? $value['subdomain'].'.'.$domainname : '';
                    SubdomainFldTransactional::create([
                        'subdomainid'=> 'SUBD' .date('dmy'). bin2hex(random_bytes(8)),
                        'subdomainname' => $subdomainname,
                        'domainid' => $this->selectedDomainid,
                        'multipleips' => !empty($value['ips'])? serialize($value['ips']):serialize([]),
                        'multiplecname' => !empty($value['cName'])? serialize([$value['cName']]) : serialize([]), 
                        'signedby' => $this->selectedSigningAthority          
                    ]);
                }             
            }elseif($this->isSameMapping && !empty($this->multiSubDomainName)){
                foreach($this->multiSubDomainName as $value){
                  //  $subdomainid = 'SUBD' .date('dmy'). bin2hex(random_bytes(8));
                  //  $subdomainname = !empty($value['subdomain'])? $value['subdomain'].'.'.$domainname : '';
                    SubdomainFldTransactional::create([
                        'subdomainid'=> 'SUBD' .date('dmy'). bin2hex(random_bytes(8)),
                        'subdomainname' => $value,
                        'domainid' => $this->selectedDomainid,
                        'multipleips' =>serialize($this->ips),
                        'multiplecname' => serialize([$this->cName]), 
                        'signedby' => $this->selectedSigningAthority          
                    ]);
                } 
            }
               

            // generate letter st 
            
            if( $this->selectedsSigningMethod == 'generateletter'){
                $data = [
                'domainname' => $domainname,
                'authorityName' => (!empty($authorityDetails) && $authorityDetails->c_name) ? $authorityDetails->c_name :'',
                'authorityDesg' => (!empty($authorityDetails) && $authorityDetails->designation) ? $authorityDetails->designation :'',
                'subdomainname' => $subdomainname,
                'isSameMapping' => $this->isSameMapping,
                'ips' =>$this->ips,
                'cname' => $this->cName,
                'date' => date('m/d/Y')

                ];

                $pdf = Pdf::loadView('livewire.backend.Letterformat.subdomain_reg_letter',$data);
                $filename = letterName($domainname,$this->selectedDomainid,'sub_reg_multi');           
                $path = storage_path("app/public/registrationletters/generated/{$filename}");           
                $pdf->save($path);
                $link = Storage::url("registrationletters/generated/{$filename}");
            
                $this->dispatch('subDomainReg', [
                    'type'  => 'success',
                    'title' => 'Letter Generated',
                    'text'  => $subdomainname,
                    'date'  => now()->format('Y-m-d'),
                    'html'  => "<p>Annexure I and II has been generated successfully.<br>
                                <a href='{$link}' target='_blank'>Download Letter.</a><br>
                                </p>",
                ]);    
            }

        }catch(\Exception $e){
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
        return view('livewire.backend.subdomain.registration.multi-subdomain-reg');
    }
}
