<?php

namespace App\Livewire\Backend\Domainregistration;

use App\Models\Domain;
use App\Models\Contact;
use App\Models\StateUt;
use Livewire\Component;
use App\Models\Ministry;
use App\Helpers\Punycode;
use App\Models\Idndomain;
use App\Models\Department;
use App\Models\IdnLanguage;
use App\Models\Orgcategory;
use App\Models\Organisation;
use Livewire\Attributes\Title;
use App\Models\Nameserver_data;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use App\Models\DomainRegistraionMultiStep;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Mail;

class Registrationform extends Component
{


    public $userId = 1;
    /** First step */
    public $showAlert = false;
    public $language_code;
    public $domainname;
    public $hindidomainname;
    public $state_domain;
    public $region;
    public $isaddOrganisation=false;
    public $customMsg = '';
    public $ips = [];
    // public $states=[];

    /**Multi dropdown */

    public $orgCategories=[];
    public $ministries=[];
    public $departments=[];
    public $organisations=[];
    public $selectedOrgcategory=null;
    public $selectedMinistry=null;
    public $selectedDepartment=null;
    public $selectedOrganisation=null;  
    public $addnewOrganisation = '';
    public $selectedState = '';
   
    
    /** Second step */
   
    public $orgName;
    public $orgDesignation;
    public $orgAddress1;
    public $orgAddress2;
    public $orgCity;
    public $orgState;
    public $orgPincode;
    public $orgTelephoneNo;
    public $orgStdCode;
    public $orgMobileNo;
    public $orgEmailId;
    public $orgCountryDialCode;
    public $orgCountry;

    /** Third step */
   
    public $adminName;
    public $adminDesignation;
    public $adminAddress1;
    public $adminAddress2;
    public $adminCity;
    public $adminState;
    public $adminPincode;
    public $adminTelephoneNo;
    public $adminStdCode;
    public $adminMobileNo;
    public $adminEmailId;
    public $adminCountryDialCode;
    public $adminCountry;


    /** Fourth step */

    public $techName;
    public $techDesignation;
    public $techAddress1;
    public $techAddress2;
    public $techCity;
    public $techState;
    public $techPincode;
    public $techTelephoneNo;
    public $techStdCode;
    public $techMobileNo;
    public $techEmailId;
    public $techCountryDialCode;
    public $techCountry;



    public $isChecked=true;
    public $isdepartmentVisible;
    public $multipleip= [];

    /** Nameserver */
   
    public $totalStep=5;
    public $currentStep=1;

    #[Title('Domain Registration')]

        public function mount(){

            $this->currentStep = 1;
            // $this->multipleip = ['nshostname' => '', 'ip' => []];
            $this->multipleip = [
                                    ['nshostname' => '', 'ip' => ['']],
                                    ['nshostname' => '', 'ip' => ['']],
                                ];
            $this->isaddOrganisation = false;
            $this->isdepartmentVisible = false;

            $draft = DomainRegistraionMultiStep::where('userid', $this->userId)
                ->where('form_id', 1)
                ->first();

            if ($draft) {
                foreach (json_decode($draft->formdata, true) as $field => $value) {
                    if (property_exists($this, $field)) {
                        $this->$field = $value;
                    }
                }
                $this->currentStep = $draft->formlevel ?? 1;
                $this->orgCategories = Cache::get("orgCategories_{$this->userId}", []);
                $this->ministries = Cache::get("ministries_{$this->userId}", []);
                $this->departments = Cache::get("departments_{$this->userId}", []);
                $this->organisations = Cache::get("organisations_{$this->userId}", []);
            }
           
            


            // Fetch orgCategories based on the prefilled region
           // if (!empty($this->region)) {
                // $this->orgCategories = Orgcategory::where('region', $this->region)->where('is_active', 1)->get();
            //}
        }


        public function increaseStep(){
                   
            $this->resetErrorBag();
            $this->validateData();

            // Decide prefix string based on step
            $prefixStr = null;
            if (in_array($this->currentStep, [2, 3, 4])) {
                if ($this->currentStep == 2) {
                    $prefixStr = 'org';
                } elseif ($this->currentStep == 3) {
                    $prefixStr = 'admin';
                } elseif ($this->currentStep == 4) {
                    $prefixStr = 'tech';
                }
            }

            // Validate + save draft
            $this->saveDraft($prefixStr);

            $this->currentStep++;

   
            if($this->currentStep > $this->totalStep){
                $this->currentStep = $this->totalStep;
            }

            
        }

        public function decreaseStep(){
            $this->resetErrorBag();
            $this->currentStep--;
            if($this->currentStep < 1){
                $this->currentStep = 1;
            }
        }

        private function rulesForStep1()
        {
            return [
                'region' => 'required',
                'domainname' => ['required','regex:/^(?!-)(?!.*\s)[\p{L}\p{M}\p{N}-]+(?<!-)$/u'],
                'language_code' => 'required',
                'selectedOrgcategory' => 'required',
                'selectedOrganisation' => 'required_if:addnewOrganisation,""',
                'selectedState' => 'required_if:region,2',
                'selectedMinistry' => 'required_if:region,1',
                'selectedDepartment' => 'required_if:selectedOrgcategory,4,10',
                'addnewOrganisation' => [
                                            'nullable',
                                            'regex:/^[a-zA-Z\s]+$/',
                                            'required_without:selectedOrganisation',
                                        ],
                'hindidomainname'=> [
                                        'nullable',
                                        'required_if:language_code,en',
                                        'regex:/^(?!-)(?!.*\s)[\p{L}\p{M}\p{N}-]+(?<!-)$/u',
                                    ],

            ];
        }

        private function messagesForStep1()
        {
            return [
                'region.required' => 'Please select region.',
                'language_code.required' => 'Please select language.',
                'domainname.required' => 'Domain name is required.',
                'domainname.regex' => 'Domain name may only contain letters, numbers, and hyphens, cannot start or end with a hyphen, and must not contain spaces.',
                'hindidomainname.required_if' => 'Hindi Domain name is required.',
                'hindidomainname.regex' => 'Domain name may only contain letters, numbers, and hyphens, cannot start or end with a hyphen, and must not contain spaces.',
                'selectedMinistry.required_if' => 'Please select ministry when region is Central.',
                'selectedOrgcategory.required' => 'Organisation Category is required.',
                'selectedOrganisation.required_if' => 'Organisation is required.',
                'selectedState.required_if' => 'State is required.',
                'selectedDepartment.required_if' => 'Department is required.',
                'addnewOrganisation.regex' => 'The organisation name may only contain letters and spaces.',
                'addnewOrganisation.required_without' => 'Please Add Organization if your organization is not available.',

            ];
        }  


        protected function rulesForStep5()
        {
            $rules = [
                'multipleip.*.nshostname' => [
                    'required',
                    'regex:/^(?=.{1,253}$)(?!-)([a-zA-Z0-9-]{1,63}\.)+[a-zA-Z]{2,63}$/'
                ],
            ];

            foreach ($this->multipleip as $index => $entry) {
                if (!empty($entry['nshostname']) && str_ends_with($entry['nshostname'], '.gov.in')) {
                    $rules["multipleip.$index.ip.*"] = 'required|ip';
                }
            }

            return $rules;
        }


        private function messagesForStep5()
        {
            return [
                    'multipleip.*.nshostname.required' => 'Each nameserver must have a hostname.',
                    'multipleip.*.nshostname.regex'    => 'Each nameserver must be a valid hostname.',
                    'multipleip.*.ip.*.required'       => 'IP address is required when hostname ends with .gov.in.',
                    'multipleip.*.ip.*.ip'             => 'Each IP must be a valid IPv4 or IPv6 address.',
                   ];
        }

        private function rules($prefixStr)
        {
            
            $rules =  [
                $prefixStr.'Name'=>['required','max:200','regex:/^[a-zA-Z\s]+$/'],
                $prefixStr.'Designation'=>['required','regex:/^[a-zA-Z\s]+$/'],
                $prefixStr.'MobileNo'=>['required','regex:/^[1-9][0-9]{9}$/'],
                $prefixStr.'EmailId'=>['required','regex:/^[a-zA-Z0-9_.+-]+@(?:(?:[a-zA-Z0-9-]+\.)?[a-zA-Z0-9-]+\.)?(nic|gov)\.in$/'],
                $prefixStr.'City'=>['required','regex:/^[a-zA-Z\s]+$/'],
                $prefixStr.'State'=>'required|regex:/^[a-zA-Z\s]+$/',
                $prefixStr.'Pincode' => ['required','digits:6'],
                $prefixStr.'TelephoneNo'=>'required|regex:/^[0-9]{4,8}+$/',
                $prefixStr.'StdCode'=>'required|regex:/^[0-9]{2,4}+$/',
                $prefixStr.'Address1' => ['required','string','min:5','max:255','regex:/^(?!\d+$)[A-Za-z0-9\s,.\-#]+$/' ],
                $prefixStr.'CountryDialCode' => 'nullable|required_if:selectedMinistry,14|numeric|min:1|max:9999',
                $prefixStr.'Country' => 'nullable|required_if:selectedMinistry,14|regex:/^[a-zA-Z\s]+$/',
            ];

            if ($prefixStr === 'admin') {
                $rules['adminEmailId'][] = 'different:orgEmailId';
            }
             return $rules;
        }

        private function messages($prefixStr)
        {
            $messages =  [
                $prefixStr.'Name.required' => 'Name is required',
                $prefixStr.'Name.regex'=>'Only character and space is allowed',
                $prefixStr.'City.required' => 'City is required',
                $prefixStr.'City.regex'=>'Only character and space is allowed',
                $prefixStr.'State.required' => 'State is required',
                $prefixStr.'Pincode.required' => 'Pincode is required.',
                $prefixStr.'Pincode.digits' => 'Pincode must be exactly 6 digits.',
                $prefixStr.'Address1.required' => 'Address is required.',
                $prefixStr.'Address1.string' => 'Address must be a valid string.',
                $prefixStr.'Address1.min' => 'Address must be at least 5 characters.',
                $prefixStr.'Address1.max' => 'Address may not be greater than 255 characters.',
                $prefixStr.'Address1.regex' => 'Address cannot be only numbers and may only contain letters, numbers, spaces, commas, periods, dashes, or #.',
                $prefixStr.'Designation.required' => 'Designation is required',
                $prefixStr.'Designation.regex'=>'Only character and space is allowed',
                $prefixStr.'EmailId.required' =>'Email id is required',
                $prefixStr.'EmailId.regex'=>'Email id will be @nic.in or @gov.in',
                $prefixStr.'TelephoneNo.required' => 'Telephone No is required',
                $prefixStr.'TelephoneNo.regex'=>'Telephone No should be minimum 4 digits and maximum 8 digits',
                $prefixStr.'StdCode.required'=>'Please enter STD code',
                $prefixStr.'StdCode.regex'=>'STD code should be minimum 2 digits and maximum 4 digits',
                $prefixStr.'MobileNo.required' =>'Mobile No is required',
                $prefixStr.'MobileNo.regex'=>'The mobile number must be 10 digits and should not start with 0',
                $prefixStr.'CountryDialCode.required_if'=>'CountryDialCode is required.',
                $prefixStr.'Country.required_if'=>'Country is required.',
                $prefixStr.'Country.regex'=>'Only character and space is allowed',
                $prefixStr.'State.regex'=>'Only character and space is allowed',
               
            ];

            if ($prefixStr == 'admin') {
                $messages['adminEmailId.different'] = 'Organizational and administrative contact person should not have same email id';
            }
             
            return $messages;
        }  

        
        public function validateData()
        {
            
            if($this->currentStep == 1){
                $this->validate($this->rulesForStep1(), $this->messagesForStep1());

            }elseif(in_array($this->currentStep,[2,3,4])){

                if($this->currentStep == 2){
                    $prefixStr = 'org';
                } elseif($this->currentStep == 3){
                    $prefixStr = 'admin';
                } elseif($this->currentStep == 4){
                    $prefixStr = 'tech';
                }else{
                    $prefixStr='';
                }                
                $this->validate($this->rules($prefixStr), $this->messages($prefixStr));

            }elseif( $this->currentStep == 5 ){

                if (!$this->isChecked) {
                    $this->validate($this->rulesForStep5(), $this->messagesForStep5());
                }
    
            }
        }

        public function updatedIsChecked($value)
        {
        
            // $value contains the updated value of the checkbox (true or false)
            if ($value) {
                $this->multipleip = [
                    ['nshostname' => 'ns1.nic.in', 'ip' => ['']],
                    ['nshostname' => 'ns2.nic.in', 'ip' => ['']],
                    ['nshostname' => 'ns7.nic.in', 'ip' => ['']],
                    ['nshostname' => 'ns10.nic.in','ip' => ['']],
                ];
            } else {
                // $this->multipleip = ['nshostname' => '', 'ip' => []];
                 $this->multipleip = [
                                        ['nshostname' => '', 'ip' => ['']],
                                        ['nshostname' => '', 'ip' => ['']],
                                    ];
            }
        }
        public function addEntry()
        {
            $this->multipleip[] = ['nshostname' => '', 'ip' => ['']];
        }
    
        public function removeEntry($index)
        {
            if($index > 1){
                unset($this->multipleip[$index]);
                $this->multipleip = array_values($this->multipleip);
            }
        }

         // add IP field inside a specific entry
        public function addIp($entryIndex)
        {
             if (count($this->multipleip[$entryIndex]['ip']) < 5) {   // max 5
              $this->multipleip[$entryIndex]['ip'][] = '';
             }
        }

        // remove IP field from a specific entry
        public function removeIp($entryIndex, $ipIndex)
        {
            unset($this->multipleip[$entryIndex]['ip'][$ipIndex]);
            $this->multipleip[$entryIndex]['ip'] = array_values($this->multipleip[$entryIndex]['ip']);
        }

        public function register(){

                $this->validateData();
                try {

                        DB::beginTransaction();

                        $extension = '.gov.in'; // default

                        if ($this->language_code !== 'en') {
                            $ext = IdnLanguage::where('lang_code', $this->language_code)->first();
                            $extension = $ext->extension ?? '.gov.in'; 
                        }

                        $fullDomain = $this->domainname . $extension;

                       
                        $domainname    = $this->language_code === 'en' ? $fullDomain : Punycode::encodeHostName($fullDomain);
                        $dname_decoded = $fullDomain;
                        $domainid='DM'.date('dmy').date('his');
                        $organisationcontact = 'ORGC'.date('dmy').date('his');
                        $admincontact = 'ADMN'.date('dmy').date('his');
                        $techcontact = 'TECH'.date('dmy').date('his');
                        $idndomainid ='IDN'.date('dmy').date('his');
                        $currentDate=date('Y-m-d H:i:s');

                        /**Add organisation if it doesn't exist */

                        if(!empty($this->addnewOrganisation) && empty($this->selectedOrganisation)){

                            $org = Organisation::insert([
                                'org_name'=> $this->addnewOrganisation,
                                'm_id'=>$this->selectedMinistry,
                                'dept_id'=>$this->selectedDepartment,
                                'orgcat_id'=>$this->selectedOrgcategory,
                                'state_utcode'=>$this->region == 2 ? $this->selectedState : 'cu',
                            ]);

                            $this->selectedOrganisation = $org->org_id;

                        }

                
                        /** Main domain table insert */
                        Domain::create([
                            'domainid' => $domainid,
                            'domainname' => $domainname,
                            'lang' =>$this->language_code,
                            'dname_decoded_punycode' => $dname_decoded,
                            'registrantid' => $this->userId,
                            'companyid' =>  $organisationcontact,
                            'adminid' =>  $admincontact,
                            'techid' => $techcontact,
                            'registrationdate' => $currentDate,
                            'state_utcode'=>$this->region == 2 ? $this->selectedState : 'cu',
                            'orgcategory' => $this->selectedOrgcategory,
                            'region' => $this->region,
                            'ministry' => $this->selectedMinistry,
                            'dept' => $this->selectedDepartment,
                            'org_id' => $this->selectedOrganisation,
                            'has_idns'=>$this->language_code == 'en'? 1 : 0,
                            'remarks' =>'',
                            'nic_hosting'=> $this->isChecked ? 1 : 2
                            
                        ]);

                        /**Hindi domain insert */
                        if($this->language_code == 'en'){
                            Idndomain::insert([
                                'domainname'=> Punycode::encodeHostName($this->hindidomainname.'.सरकार.भारत'),
                                'domainname_decoded' => $this->hindidomainname.'.सरकार.भारत',
                                'master_domainid'=>$domainid,
                                'domainid'=>$idndomainid,
                                'lang'=>'hin-deva'
                            ]);
                        }
                       
                        //insert in Organistion contacts
                    
                        Contact::create([
                                'contactid'=>$organisationcontact,
                                'c_name' => $this->orgName,
                                'designation' => $this->orgDesignation,
                                'address1' => $this->orgAddress1,
                                'address2' => $this->orgAddress2,
                                'city' => $this->orgCity,
                                'state' => $this->orgState,
                                'countryid' => $this->orgCountry??'India',
                                'pincode' => $this->orgPincode,
                                'telephone_std_code' => $this->orgStdCode,
                                'telephone' => $this->orgTelephoneNo,
                                'mobileno' => $this->orgMobileNo,
                                'email' => $this->orgEmailId,
                                'country_dial_code' => $this->orgCountryDialCode ?? 91
                            ]);

                       //  dd('org', $this->orgState,$this->orgCountry,$this->orgCountryDialCode,'tech',$this->techState,$this->techCountry,'admin',$this->adminState,$this->adminCountry);  
                        //insert in Admin contacts
            
                        Contact::create([
                            'contactid'=>$admincontact,
                            'c_name' => $this->adminName,
                            'designation' => $this->adminDesignation,
                            'address1' => $this->adminAddress1,
                            'address2' => $this->adminAddress2,
                            'city' => $this->adminCity,
                            'state' => $this->adminState,
                            'countryid' => $this->adminCountry??'India',
                            'pincode' => $this->adminPincode,
                            'telephone_std_code' => $this->adminStdCode,
                            'telephone' => $this->adminTelephoneNo,
                            'mobileno' => $this->adminMobileNo,                    
                            'email' => $this->adminEmailId,
                            'country_dial_code' => $this->adminCountryDialCode ?? 91
                        ]);

                        //insert in Technical contacts
                        Contact::create([
                                'contactid'=>$techcontact,
                                'c_name' => $this->techName,
                                'designation' => $this->techDesignation,
                                'address1' => $this->techAddress1,
                                'address2' => $this->techAddress2,
                                'city' => $this->techCity,
                                'state' => $this->techState,
                                'countryid' => $this->techCountry??'India',
                                'pincode' => $this->techPincode,
                                'telephone_std_code' => $this->techStdCode,
                                'telephone' => $this->techTelephoneNo,
                                'mobileno' => $this->techMobileNo,
                                'email' => $this->techEmailId,
                                'country_dial_code' => $this->techCountryDialCode ?? 91

                        ]);

                        /** Nameserver Data */
                        Nameserver_data::create([
                                'domainid' => $domainid,
                                'current_data_sets' => serialize($this->multipleip),
                                'activation_status' => 'Pending',
                        ]);

                        if(!empty($this->multipleip) && !$this->isChecked ){
                            foreach($this->multipleip as $key => $val){
                                DB::table('nameservers')->insert([
                                    'hostname'          => $val['nshostname'],
                                    'ipaddress' => serialize($val['ip']),
                                ]);
                            }
                        }
                       
                        DB::commit();
                        

                        DomainRegistraionMultiStep::where('userid', 1)
                                                    ->where('form_id', 1)
                                                    ->delete();
                        
                                    
                        $body = "You have successfully submitted your request for the Domain Name - <strong> $fullDomain </strong><br>
                                <p>The Requested Details are:</p>
                                <p>
                                Domain:<strong> $fullDomain</strong><br>
                                Requested on:".date('d-m-Y')."<br>
                                Domain Status:Pending - Waiting for Authorization & Forwarding Letter </strong></p>General Instructions:<ol>
                                <li>Generate the Authorization and Forwarding Letters formats through the registry site only and do not change the content of the format</li>

                                <li>GOV.IN domain registry will contact you in case of further clarification on your registered email id(s).</li>
                                <li>You may see the status of your domain registration request online at our registry website under your login account.</li>
                                <li>You may seek assistance lodge complain through our servicedesk- http://servicedesk.nic.in/ or may call on Toll Free No- 1800 111 555. Please note that domain name is essential for getting service through service desk.</li>
                                </ol>
                                <p><i><strong>Please note that domain name is essential for getting service through service desk.</strong></i></p>";
                            
                        $mail_subject = "Registration Request Submitted For Domain Name:$fullDomain";

                        Mail::to(['dev-webtech@govcontractor.in',$this->techEmailId,$this->adminEmailId,$this->orgEmailId])->send(
                                new SendMail( $body, $mail_subject)
                              );
                          
                        $this->dispatch('formSubmitted', [
                            'icon' => 'success',
                            'title' => 'Domain Registered successfully',
                            'text' => $fullDomain,
                            'html' => "<table class='table table-bordered'><tbody>
                                <tr style='text-align:left'><td>Domain Name</td><td><strong>{$fullDomain}</strong></td></tr>
                                <tr style='text-align:left'><td>Domain Status</td><td><strong>Pending - Waiting for Authorization & Forwarding Letter</strong></td></tr>
                                </tbody>
                                </table>
                                <p><strong class='text-success'>Follow the steps to activate the domain</strong></p>              
                                <ul style='text-align:left'>
                                    <a href='/user/generateletter'><li>Please Generate and submit the Authorization & Forwarding (Annexure - I & Annexure - II)</li></a>
                                    <li>Generate the Authorization and Forwarding Letters formats through the registry site only and do not change the content of the format.</li>
                                    <li>Follow the instruction for generating and signing Authorization(Annexure-I) and Forwarding Letter(Annexure-II) online for registration of the domain.</li>
                                    <li>User may refer <a href='/helpdoc.php' target='_blank'>Help video</a> for complete assistance.</li>
                                    <li>You may see the status of your domain registration request online at our <a href='/domain_status' target='_blank'>registry</a> website.</li>
                                </ul>
                                <p>Thank you for requesting domain name under GOV.IN.</p>"
                        ]);


                        

                } catch (\Exception $e) {

                    // Transaction automatically rolls back if an exception is thrown
                    // Handle or log the error as needed
                //  throw $e; // or log the error if needed

                DB::rollBack();
                Log::error('Transaction failed: ' . $e->getMessage());
                
                    $this->dispatch('formSubmitted', [
                        'icon' => 'error',
                        'type' => 'danger',
                        'title' => 'Domain Registration failed',
                        'text' => $e->getMessage(),
                        'date' => date('Y-m-d'),
                        'html' => "<p>{$e->getMessage()} There is some issue with registration. Please write to us at support@registry.gov.in</p>"
                    ]);
                }
            
        
        }

        public function saveDraft($prefixStr = null)
        {
            // Collect only validated step data
            if ($this->currentStep == 1) {
                $formData = $this->validate($this->rulesForStep1(), $this->messagesForStep1());
            } elseif (in_array($this->currentStep, [2,3,4])) {
                $formData = $this->validate($this->rules($prefixStr), $this->messages($prefixStr));
            } elseif ($this->currentStep == 5 && !$this->isChecked) {
                $formData = $this->validate($this->rulesForStep5(), $this->messagesForStep5());
            } else {
                $formData = [];
            }

            // Save draft
            DomainRegistraionMultiStep::updateOrCreate(
                [
                    'userid'  => $this->userId,
                    'form_id' => 1,
                ],
                [
                    'formdata'  => json_encode(array_merge(
                        $this->getDraftData(), // keep old saved steps
                        $formData              // merge current step
                    )),
                    'formlevel' => $this->currentStep,
                ]
            );

            Cache::put("orgCategories_{$this->userId}", $this->orgCategories);
            Cache::put("ministries_{$this->userId}", $this->ministries);
            Cache::put("departments_{$this->userId}", $this->departments);
            Cache::put("organisations_{$this->userId}", $this->organisations);

           
        }

        protected function getDraftData()
        {
            $draft = DomainRegistraionMultiStep::where('userid', 1)
                        ->where('form_id', 1)
                        ->first();

            return $draft ? json_decode($draft->formdata, true) : [];
        }


        /** Multilevel Dropdown*/

        public function updatedregion($region)
        {
            
            // $this->resetErrorBag('region');
            $this->orgCategories = Orgcategory::where('region','=',$region)->where('is_active',1)->get();
            $this->selectedOrgcategory = null;
            $this->selectedMinistry = null;
            $this->selectedDepartment = null;
            $this->selectedOrganisation = null;
            $this->selectedState= null;
            $this->organisations = [];
            $this->customMsg = '';
           // $this->state_domain= null;
           // dd($this->orgCategories);
           
        }
    
        public function updatedSelectedState($state){
            // $this->resetErrorBag('selectedState');
            $this->organisations = Organisation::where('state_utcode', '=', $state)
                    ->where('orgcat_id', '=', $this->selectedOrgcategory)->get();
            $this->customMsg = (!empty( $this->organisations) && count($this->organisations) > 0)
                        ? ""
                        :'No Organisation for this State please select another State.' ;
            if(!empty($this->customMsg)){
                $this->selectedOrganisation = null;
            }
               

        }

        public function updatedSelectedOrgcategory($orgCategory)
        {

            $getorgcatRow= Orgcategory::where('orgcatid',$orgCategory)->first(); 
            $orgcat = ($getorgcatRow && $getorgcatRow->ministry_is_visible < 1)? $orgCategory : 0;       
            $this->ministries = Ministry::where('orgcatid','=',$orgcat)->get();
            $this->isaddOrganisation = !empty($getorgcatRow) && $getorgcatRow->add_organisation == 1 ? true : false;
            $this->isdepartmentVisible = !empty($getorgcatRow) && $getorgcatRow->dept_is_visible == 1 ? true : false; 
            $this->selectedMinistry = null;
            $this->selectedDepartment = null;
            $this->selectedOrganisation = null;
            $this->departments = [];
            $this->organisations = [];    
        }
    
        public function updatedSelectedOrganisation($value)
        {
            if (!empty($value)) {
                $this->addnewOrganisation = '';
            }
        }
        public function updatedSelectedMinistry($ministry)
        {
            $this->addnewOrganisation = '';
            $this->departments = Department::where('m_id','=',$ministry)->get();

           if($this->selectedOrgcategory == '6'){ // For orgcategory MUI, show only ministry
                $this->selectedDepartment = 0;
                $this->selectedOrganisation = 0;  
           }elseif($this->selectedOrgcategory == '4' || $this->selectedOrgcategory == '10' ){ // For orgcategory DUI , show only ministry and dept
               
               // $this->departments = Department::where('m_id','=',$ministry)->get();
                $this->customMsg = (!empty( $this->departments) && count($this->departments) > 0)
                                    ? ""
                                    :'No department for this ministry please Either select another ministry Or Organization Category.' ; 
                $this->selectedDepartment = null;
  
           }else{

                // $this->departments = Department::where('m_id','=',$ministry)->get();
              
                if(in_array($this->selectedOrgcategory,[1,2,3,5,7])){
                    $this->selectedDepartment = 0;
                    $this->departments = [];
                } 

                $this->organisations = Organisation::where('m_id', '=', $this->selectedMinistry)
                ->where('orgcat_id', '=', $this->selectedOrgcategory)->get();

                $this->selectedOrganisation = null;
                   
           }  
        }

        public function updatedselectedDepartment($department)
        {
           // $this->resetErrorBag('selectedDepartment');
            if($this->selectedOrgcategory == '4'){
               $this->selectedOrganisation = 0; 
               $this->organisations = [];
            }else{
                $query = Organisation::query();

                if ($department > 0 || $department != null) {
                    $query->where('dept_id', '=', $department);
                }

                $query->where('m_id', '=', $this->selectedMinistry)
                    ->where('orgcat_id', '=', $this->selectedOrgcategory);

                $this->organisations = $query->get();
            }
            
                    
        }

        public function updated($propertyName)
        {
            $this->customMsg = '';
            $this->resetErrorBag($propertyName);
        }

    

    public function render(){
        
        $languages = IdnLanguage::where('is_active',1)->get();
        $states = StateUt::all();
        $langentension = IdnLanguage::where('lang_code',$this->language_code)->first();
      
        return view('livewire.backend.domainregistration.registrationform',[
            'languages'=>$languages,
            'states'=>$states,
            'language_extension'=>$langentension,
        ]);
    }
}
