<?php

namespace App\Livewire\Domainregistration;

use App\Models\Domain;
use App\Models\Contact;
use App\Models\StateUt;
use Livewire\Component;
use App\Models\Ministry;
use App\Helpers\Punycode;
use App\Models\Idndomain;
use App\Rules\DomainRule;
use App\Models\Department;
use App\Models\IdnLanguage;
use App\Models\Orgcategory;
use App\Models\Organisation;
use Livewire\Attributes\Title;
use App\Models\Nameserver_data;
use App\Models\StdCodes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Registrationform extends Component
{


    /** First step */
    public $showAlert = false;
    public $language_code;
    public $domainname;
    public $hindidomainname;
    public $state_domain;
    public $region;
    public $isaddOrganisation;


    /**Multi dropdown */

    public $orgCategories=[];
    public $ministries=[];
    public $departments=[];
    public $organisations=[];
    public $selectedOrgcategory=null;
    public $selectedMinistry=null;
    public $selectedDepartment=null;
    public $selectedOrganisation=null;  
    
    /** Second step */
   
    public $orgName;
    public $orgDesignation;
    public $orgAddress1;
    public $orgAddress2;
    public $orgCity;
    public $orgState;
    public $orgPincode;
    public $orgTelehponeNo;
    public $orgstdcode;
    public $orgmobileNo;
    public $orgemailid;

    /** Third step */
   
    public $adminName;
    public $adminDesignation;
    public $adminAddress1;
    public $adminAddress2;
    public $adminCity;
    public $adminState;
    public $adminPincode;
    public $adminTelehponeNo;
    public $adminstdcode;
    public $adminmobileNo;
    public $adminemailid;

    /** Fourth step */

    public $techName;
    public $techDesignation;
    public $techAddress1;
    public $techAddress2;
    public $techCity;
    public $techState;
    public $techPincode;
    public $techTelehponeNo;
    public $techstdcode;
    public $techmobileNo;
    public $techEmailid;
    public $isChecked=true;
    public $isdepartmentVisible;
    public $multipleip= [];

    /** Nameserver */
   
    public $totalStep=5;
    public $currentStep=1;

    #[Title('Domain Registration')]
        public function mount(){

            $this->currentStep = 2;
            $this->multipleip = ['nshostname' => '', 'ip' => []];
            $this->isaddOrganisation = false;
             $this->isdepartmentVisible = false;
        }

        public function increaseStep(){

            $this->resetErrorBag();
            $this->validateData();
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

      public function validateData(){

        if( $this->currentStep == 1){
                $this->validate([
                    'region'=>'required',
                    'language_code'=>'required',
                    'domainname'=>['required',new DomainRule()],
                    'hindidomainname'=>'required',
                    'selectedOrgcategory'=>'required',
                    'selectedMinistry'=>'required_if:region,1 ',
                    'state_domain'=>'required_if:region,2',
                ],
                [
                    'selectedOrgcategory.required' => 'Organisation Category is required',
                    'hindidomainname.required' => 'Hindi Domain name in required',
                    'language.required' => 'Please choose language of domain',
                    'selectedMinistry.required_if'=>'Please select ministry',
                    'state_domain.required_if'=>'Please select state'
                ]);
        }
        if( $this->currentStep == 2){

            $this->validate([
                'orgName'=>'required',
                'orgDesignation'=>['required','regex:/^[a-zA-Z\s]+$/'],
                'orgmobileNo'=>['required','regex:/^(\+?\d{1,3})?\d{10}$/'],
                'orgemailid'=>['required','regex:/^[a-zA-Z0-9_.+-]+@(?:(?:[a-zA-Z0-9-]+\.)?[a-zA-Z0-9-]+\.)?(nic|gov)\.in$/'],
                'orgCity'=>['required','regex:/^[a-zA-Z\s]+$/'],
                'orgState'=>'required',
                'orgPincode'=>'required |min:6 |numeric',
                'orgTelehponeNo'=>'required|numeric|max:8|min:8',
                'orgstdcode'=>'required|numeric |max:4|min:2',
                'orgAddress1'=>'required'
            
            ],
            [
                'orgName.required' => 'Name is required',
                'orgDesignation.required' => 'Designation is required',
                'orgCity.required' => 'City is required',
                'orgState.required' => 'State is required',
                'orgPincode.required' => 'Pincode is required',
                'orgTelehponeNo.required' => 'Telephone No is required',
                'orgmobileNo.required' =>'Mobile No is required',
                'orgemailid.required' =>'Email id is required',
                'orgAddress1.required' =>'Address is required',
                'orgDesignation.regex'=>'Only character and space is allowed',
                'orgemailid.regex'=>'Email id will be @nic.in or @gov.in',
                'orgstdcode.required'=>'Please enter STD code',
                'orgstdcode.max'=>'STD code should be 4 digit',
                'orgstdcode.min'=>'STD code should be minimum 2 digit',
                'orgTelehponeNo.max'=>'Telephone No should be 8 digit',
                'orgTelehponeNo.min'=>'Telephone No should be 8 digit',
                'orgstdcode.numeric'=>'Neumeric value is required for STD code',
      
            
            ]);
        }
        if( $this->currentStep == 3){
            
                $this->validate([
                    'adminName'=>'required',
                    'adminDesignation'=>['required','regex:/^[a-zA-Z\s]+$/'],
                    'adminmobileNo'=>['required','regex:/^(\+?\d{1,3})?\d{10}$/'],
                    'adminemailid'=>['required','regex:/^[a-zA-Z0-9_.+-]+@(?:(?:[a-zA-Z0-9-]+\.)?[a-zA-Z0-9-]+\.)?(nic|gov)\.in$/'],
                    'adminCity'=>['required','regex:/^[a-zA-Z\s]+$/'],
                    'adminState'=>'required',
                    'adminPincode'=>'required|min:6|numeric',
                    'adminTelehponeNo'=>'required|numeric|max:8|min:8',
                    'adminstdcode'=>'required|numeric |max:4|min:2',
                    'adminAddress1' =>'required'
                
                ],
                [
                    'adminName.required' => 'Name is required',
                    'adminDesignation.required' => 'Designation is required',
                    'adminCity.required' => 'City is required',
                    'adminState.required' => 'State is required',
                    'adminPincode.required' => 'Pincode is required',
                    'adminTelehponeNo.required' => 'Telephone No is required',
                    'adminmobileNo.required' =>'Mobile No is required',
                    'adminemailid.required' =>'Email id is required',
                    'adminAddress1.required' =>'Address is required',
                    'adminemailid.different'=>'The organisation emailid and Administrative emial id should not be same',
                    'adminDesignation.regex'=>'Only character and space is allowed',
                    'adminemailid.regex'=>'Email id will be @nic.in or @gov.in',
                    'adminstdcode.required'=>'Please enter STD code',
                    'adminstdcode.max'=>'STD code should be 4 digit',
                    'adminstdcode.min'=>'STD code should be minimum 2 digit',
                    'adminTelehponeNo.max'=>'Telephone No should be 8 digit',
                    'adminTelehponeNo.min'=>'Telephone No should be 8 digit',
                    'adminstdcode.numeric'=>'Neumeric value is required for STD code',
    

                
                ]);
            }
        if( $this->currentStep == 4){

            $this->validate([
                'techName'=>'required',
                'techDesignation'=>['required','regex:/^[a-zA-Z\s]+$/'],
                'techmobileNo'=>['required','regex:/^(\+?\d{1,3})?\d{10}$/'],
                'techEmailid'=>['required','regex:/^[a-zA-Z0-9_.+-]+@(?:(?:[a-zA-Z0-9-]+\.)?[a-zA-Z0-9-]+\.)?(nic|gov)\.in$/'],
                'techCity'=>['required','regex:/^[a-zA-Z\s]+$/'],
                'techState'=>'required',
                'techPincode'=>'required|min:6|numeric',
                'techTelehponeNo'=>'required| numeric|max:8|min:8',
                'techstdcode'=>'required|numeric |max:4|min:2',
                'techAddress1' =>'required'
            
            ],
            [
                'techName.required' => 'Name is required',
                'techDesignation.required' => 'Designation is required',
                'techCity.required' => 'City is required',
                'techState.required' => 'State is required',
                'techPincode.required' => 'Pincode is required',
                'techTelehponeNo.required' => 'Telephone No is required',
                'techmobileNo.required' =>'Mobile No is required',
                'techEmailid.required' =>'Email id is required',
                'techAddress1.required' =>'Address is required',
                'techDesignation.regex'=>'Only character and space is allowed',
                'techEmailid.regex'=>'Email id will be @nic.in or @gov.in',
                'techstdcode.required'=>'Please enter STD code',
                'techTelehponeNo.max'=>'Telephone No should be 8 digit',
                'techTelehponeNo.min'=>'Telephone No should be 8 digit',
                'techstdcode.numeric'=>'Neumeric value is required for STD code',

            
            ]);
        } 
        if( $this->currentStep == 5){

            if (!$this->isChecked) {
                    if (count($this->multipleip) < 2) {
                        $this->addError('multipleip', 'Add minimum two nameservers');
                    } else {
                        $this->validate([
                            'multipleip.*.nshostname' => 'required',
                        ], [
                            'multipleip.*.nshostname.required' => 'Each nameserver must have a hostname',
                        ]);
                    }
                }

            }
      }

    public function updatedIsChecked($value)
    {
      
        // $value contains the updated value of the checkbox (true or false)
        if ($value) {
              $this->multipleip = [
                ['nshostname' => 'ns1.nic.in', 'ip' => ''],
                ['nshostname' => 'ns2.nic.in', 'ip' => ''],
                ['nshostname' => 'ns7.nic.in', 'ip' => ''],
                ['nshostname' => 'ns10.nic.in','ip' => ''],
            ];
        } else {
            $this->multipleip = ['nshostname' => '', 'ip' => []];
        }
    }
    public function addEntry()
    {
        $this->multipleip[] = ['nshostname' => '', 'ip' => ''];
    }
    
    public function removeEntry($index)
    {
        if($index > 1){
            unset($this->multipleip[$index]);
            $this->multipleip = array_values($this->multipleip);
        }
    }


    public function register(){

            $this->validateData();

            dd($this->multipleip);
            try {
                DB::beginTransaction();
             
                    $domainname= $this->domainname.'.gov.in';
                    $domainid='DM'.date('dmy').date('his');
                    $organisationcontact = 'ORGC'.date('dmy').date('his');
                    $admincontact = 'ADMN'.date('dmy').date('his');
                    $techcontact = 'TECH'.date('dmy').date('his');
                    $idndomainid ='IDN'.date('dmy').date('his');
                    $currentDate=date('Y-m-d H:i:s');
               
                    /** Main domain table insert */
                    Domain::create([
                        'domainid' => $domainid,
                        'domainname' => $domainname,
                        'lang' =>$this->language_code,
                        'dname_decoded_punycode' => '',
                        'registrantid' => '',
                        'companyid' =>  $organisationcontact,
                        'adminid' =>  $admincontact,
                        'techid' => $techcontact,
                        'registrationdate' => $currentDate,
                        'state_utcode' =>  $this->state_domain,
                        'orgcategory' => $this->selectedOrgcategory,
                        'region' => $this->region,
                        'ministry' => $this->selectedMinistry,
                        'dept' => $this->selectedDepartment,
                        'org_id' => $this->selectedOrganisation,
                        'has_idns'=>1,
                        'remarks' =>''
                        
                    ]);

                    /**Hindi domain insert */

                    Idndomain::insert([
                        'domainname'=> Punycode::encodeHostName($this->hindidomainname.'.सरकार.भारत'),
                        'master_domainid'=>$domainid,
                        'domainid'=>$idndomainid,
                        'lang'=>'hin-deva'
                    ]);

                    //insert in Organistion contacts
                    $orgcname= $this->orgName.",".$this->orgDesignation;
                    $organisationContacttel='+91.'.$this->orgstdcode."-".$this->orgTelehponeNo;
                  
                    Contact::create([
                            'contactid'=>$organisationcontact,
                            'c_name' => $orgcname,
                            'address1' => $this->orgAddress1,
                            'address2' => $this->orgAddress2,
                            'city' => $this->orgCity,
                            'state' => $this->orgState,
                            'countryid' => 'India',
                            'pincode' => $this->orgPincode,
                            'telephone' => $organisationContacttel,
                            'mobileno' => $this->orgmobileNo,
                            'email' => $this->orgemailid,
                         ]);

                        
                     //insert in Admin contacts
                   
                     $admincname= $this->adminName.",".$this->adminDesignation;
                     $adminContacttel='+91.'.$this->adminstdcode."-".$this->adminTelehponeNo;

                   Contact::create([
                        'contactid'=>$admincontact,
                        'c_name' => $admincname,
                        'address1' => $this->adminAddress1,
                        'address2' => $this->adminAddress2,
                        'city' => $this->adminCity,
                        'state' => $this->adminState,
                        'countryid' => 'India',
                        'pincode' => $this->adminPincode,
                        'telephone' => $adminContacttel,
                        'mobileno' => $this->adminmobileNo,                    
                         'email' => $this->adminemailid
                    ]);


                    //insert in Technical contacts

                    $techcname= $this->techName.",".$this->techDesignation;
                    $techcontacttel='+91.'.$this->techstdcode."-".$this->techTelehponeNo;

                   Contact::create([
                        'contactid'=>$techcontact,
                        'c_name' => $techcname,
                        'address1' => $this->techAddress1,
                        'address2' => $this->techAddress2,
                        'city' => $this->techCity,
                        'state' => $this->techState,
                        'countryid' => 'India',
                        'pincode' => $this->techPincode,
                        'telephone' => $techcontacttel,
                        'mobileno' => $this->techmobileNo,
                        'email' => $this->techEmailid,
                    ]);
                  /** Nameserver Data */
                  Nameserver_data::create([
                        'current_data_sets' => serialize($this->multipleip),
                        'activation_status' => 'Pending',
                    ]);


                    DB::commit();

                    $this->dispatch('formSubmitted',icon:'success',title:'Domain Registered successfully',text:$domainname,html:"<table class='table table-bordered'><tbody>
                    <tr style='text-align:left' ><td>Domain Name</td><td><strong>{$domainname}</strong></td></tr>
                    <tr style='text-align:left'><td>Domain Status</td><td><strong>Pending - Waiting for Authorization & Forwarding Letter</strong></td></tr>
                    </tbody>
                    </table> 
                    <p><strong class='text-success'>Follow the steps to activate the domain</strong></p>              
                   <ul style='text-align:left'>
                        <li> Please Generate and submit the Authorization & Forwarding (Annexure - I & Annexure - II)</a> </li>
                        <li> Generate the Authorization and Forwarding Letters formats through the registry site only and do not change the content of the format.</li>
                        <li> Follow the instruction for generating and signing Authorization(Annexure-I) and Forwarding Letter(Annexure-II) online for registration of the domain.</li>
                        <li>User may refer <a href='/helpdoc.php' target='_blank'>Help video</a> for complete assistance.</li>
                        <li> You may see the status of your domain registration request online at our <a href='/domain_status' target='_blank'>registry</a> website.</li>
                    </ul>
                    <p>Thank you for requesting domain name under GOV.IN.</p></div>");

                

            } catch (\Exception $e) {

                // Transaction automatically rolls back if an exception is thrown
                // Handle or log the error as needed
               //  throw $e; // or log the error if needed

               DB::rollBack();
               Log::error('Transaction failed: ' . $e->getMessage());
               
               $this->dispatch('formSubmitted',icon:'error',type:'danger',title:'Domain Registration failed',text:$e,date:date('Y-m-d'),html:"<p>{$e->getMessage()}There is some issue with registration .Please write to us at support@registry.gov.in</p>");
            }
           
    
    }

        /** Multilevel Dropdown*/

        public function updatedregion($region)
        {
            $this->orgCategories = Orgcategory::where('region','=',$region)->get();
            $this->selectedOrgcategory = null;
           
        }
    
        public function updatedSelectedOrgcategory($orgCategory)
        {

    
            $getorgcatRow= Orgcategory::where('orgcatid',$orgCategory)->first(); 
             $orgcat = ($getorgcatRow && $getorgcatRow->ministry_is_visible < 1)
            ? $orgCategory
            : 0;       
            $this->ministries = Ministry::where('orgcatid','=',$orgcat)->get();
            $this->selectedMinistry = null;
            $this->isaddOrganisation = $getorgcatRow->add_organisation == 1 ? true : false;
            $this->isdepartmentVisible = $getorgcatRow->dept_is_visible == 1 ? true : false; 
        }
    
       
        public function updatedSelectedMinistry($ministry)
        {

            $this->departments = Department::where('m_id','=',$ministry)->get();
            $this->selectedDepartment = null;
        }

        public function updatedselectedDepartment($department)
        {
            $this->organisations = Organisation::where('dept_id','=',$department)
                                                ->where('m_id','=', $this->selectedMinistry)
                                                ->where('orgcat_id','=',$this->selectedOrgcategory)->get();
            $this->selectedOrganisation = null;
        }
        
   
    public function render(){
        
        $languages = IdnLanguage::all();
        $states = StateUt::all();
        $langentension = IdnLanguage::where('lang_code',$this->language_code)->first();
      

        return view('livewire.domainregistration.registrationform',[
            'languages'=>$languages,
            'states'=>$states,
            'language_extension'=>$langentension,
        ]);
    }
}
