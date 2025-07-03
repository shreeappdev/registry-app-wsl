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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Rules\SelectedDepartmentRequired;

class Registrationform extends Component
{


    /** First step */
    public $showAlert = false;
    public $language_code;
    public $domainname;
    public $hindidomainname;
    public $state_domain;
    public $region;
    public $isaddOrganisation=false;


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
    public $orgcountrydialcode;

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
    public $admincountrydialcode;

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
    public $techcountrydialcode;


    public $isChecked=true;
    public $isdepartmentVisible;
    public $multipleip= [];

    /** Nameserver */
   
    public $totalStep=5;
    public $currentStep=1;

    #[Title('Domain Registration')]

        public function mount(){

            $this->currentStep = 1;
            $this->multipleip = ['nshostname' => '', 'ip' => []];
          //  $this->isaddOrganisation = false;
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
                    'selectedMinistry'=>'required_if:region,1',
                    'state_domain'=>'required_if:region,2',
                    'selectedDepartment'=>[new SelectedDepartmentRequired($this->selectedOrgcategory)],       
                 ],
                [
                    'region.required' => 'Please select region',
                    'language_code.required' => 'Please select language',
                    'domainname.required' => 'Domain name is required',
                    'domainname.regex' => 'Domain name should be in format',
                    'hindidomainname.required' => 'Hindi Domain name is required',
                    'hindidomainname.regex' => 'Hindi Domain name should be in format',
                    'selectedMinistry.required_if'=>'Please select ministry in case of selected region is Central',
                    'state_domain.required_if'=>'Please select state in case of selected region is State/UT',
                    'selectedOrgcategory.required' => 'Organisation Category is required',
                    'language.required' => 'Please choose language of domain',
                    'selectedMinistry.required_if'=>'Please select ministry',
                    'state_domain.required_if'=>'Please select state',
                ]);

                if (empty($this->selectedOrganisation) && empty($this->addnewOrganisation)) {

                    if (count($this->organisations) > 0) {
                        $this->validate([
                            'selectedOrganisation' => 'required',
                        ], [
                            'selectedOrganisation.required' => 'Please select an organisation from the list',
                        ]);
                    } else {
                        $this->validate([
                            'addnewOrganisation' => 'required|regex:/^[a-zA-Z\s]+$/',
                        ], [
                            'addnewOrganisation.required' => 'Organisation name is required',
                            'addnewOrganisation.regex' => 'Only character and space is allowed',
                        ]);
                    }
                }
            }
        if( $this->currentStep == 2){

            $this->validate([
                'orgName'=>'required',
                'orgDesignation'=>['required','regex:/^[a-zA-Z\s]+$/'],
                'orgmobileNo'=>['required','regex:/^[1-9][0-9]{9}$/'],
                'orgemailid'=>['required','regex:/^[a-zA-Z0-9_.+-]+@(?:(?:[a-zA-Z0-9-]+\.)?[a-zA-Z0-9-]+\.)?(nic|gov)\.in$/'],
                'orgCity'=>['required','regex:/^[a-zA-Z\s]+$/'],
                'orgState'=>'required',
                'orgPincode'=>'required |min:6 |numeric',
                'orgTelehponeNo'=>'required|regex:/^[0-9]{4,8}+$/',
                'orgstdcode'=>'required|regex:/^[0-9]{2,4}+$/',
                'orgAddress1'=>'required',
             
            ],
            [
                'orgName.required' => 'Name is required',
                'orgCity.required' => 'City is required',
                'orgState.required' => 'State is required',
                'orgPincode.required' => 'Pincode is required',
                'orgAddress1.required' =>'Address is required',
                'orgDesignation.required' => 'Designation is required',
                'orgDesignation.regex'=>'Only character and space is allowed',
                'orgemailid.required' =>'Email id is required',
                'orgemailid.regex'=>'Email id will be @nic.in or @gov.in',
                'orgTelehponeNo.required' => 'Telephone No is required',
                'orgTelehponeNo.regex'=>'Telephone No should be minimum 4 digits and maximum 8 digits',
                'orgstdcode.required'=>'Please enter STD code',
                'orgstdcode.regex'=>'STD code should be minimum 2 digits and maximum 4 digits',
                'orgmobileNo.required' =>'Mobile No is required',
                'orgmobileNo.regex'=>'The mobile number must be 10 digits and should not start with 0',
              
              
            ]);


            if ($this->selectedMinistry == 14) {
                $this->validate([
                    'orgcountrydialcode' => ['required', 'regex:/^\+?[0-9]{1,4}$/'],
                ], [
                    'orgcountrydialcode.required' => 'Please enter country code',
                    'orgcountrydialcode.regex' => 'Country code should be in format',
                ]);
            }   
        }
        if( $this->currentStep == 3){
            
                $this->validate([
                    'adminName'=>'required',
                    'adminDesignation'=>['required','regex:/^[a-zA-Z\s]+$/'],
                    'adminmobileNo'=>['required','regex:/^[1-9][0-9]{9}$/'],
                    'adminemailid'=>['required','regex:/^[a-zA-Z0-9_.+-]+@(?:(?:[a-zA-Z0-9-]+\.)?[a-zA-Z0-9-]+\.)?(nic|gov)\.in$/'],
                    'adminCity'=>['required','regex:/^[a-zA-Z\s]+$/'],
                    'adminState'=>'required',
                    'adminPincode'=>'required|min:6|numeric',
                    'adminTelehponeNo'=>'required|regex:/^[0-9]{4,8}+$/',
                    'adminstdcode'=>'required|regex:/^[0-9]{2,4}+$/',
                    'adminAddress1' =>'required',
                
                ],
                [
                    'adminName.required' => 'Name is required',
                    'adminCity.required' => 'City is required',
                    'adminState.required' => 'State is required',
                    'adminPincode.required' => 'Pincode is required',
                    'adminAddress1.required' =>'Address is required',
                    'adminDesignation.required' => 'Designation is required',
                    'adminDesignation.regex'=>'Only character and space is allowed',
                    'adminemailid.regex'=>'Email id will be @nic.in or @gov.in',
                    'adminemailid.different'=>'The organisation emailid and Administrative emial id should not be same',
                    'adminemailid.required' =>'Email id is required',
                    'adminTelehponeNo.required' => 'Telephone No is required',
                    'adminTelehponeNo.regex' => 'Telephone No should be minimum 4 digits and maximum 8 digits',
                    'adminstdcode.required'=>'Please enter STD code',
                    'adminstdcode.regex'=>'STD code should be minimum 2 digits and maximum 4 digits',
                    'adminmobileNo.regex'=>'Mobile No should be 10 digit and ot start with 0 ',
                    'adminmobileNo.required' =>'Mobile No is required',
             
                ]);

                    if ($this->selectedMinistry == 14) {
                        $this->validate([
                            'admincountrydialcode' => ['required', 'regex:/^\+?[0-9]{1,4}$/'],
                        ], [
                            'admincountrydialcode.required' => 'Please enter country code',
                            'admincountrydialcode.regex' => 'Country code should be in format',
                        ]);
                    }
            }
        if( $this->currentStep == 4){

            $this->validate([
                'techName'=>'required',
                'techDesignation'=>['required','regex:/^[a-zA-Z\s]+$/'],
                'techmobileNo'=>['required','regex:/^[1-9][0-9]{9}$/'],
                'techEmailid'=>['required','regex:/^[a-zA-Z0-9_.+-]+@(?:(?:[a-zA-Z0-9-]+\.)?[a-zA-Z0-9-]+\.)?(nic|gov)\.in$/'],
                'techCity'=>['required','regex:/^[a-zA-Z\s]+$/'],
                'techState'=>'required',
                'techPincode'=>'required|min:6|numeric',
                'techTelehponeNo'=>'required|regex:/^[0-9]{4,8}+$/',
                'techstdcode'=>'required|regex:/^[0-9]{2,4}+$/',
                'techAddress1' =>'required',
            
            ],
            [
                'techName.required' => 'Name is required',
                'techDesignation.required' => 'Designation is required',
                'techCity.required' => 'City is required',
                'techState.required' => 'State is required',
                'techPincode.required' => 'Pincode is required',
                'techAddress1.required' =>'Address is required',
                'techDesignation.regex'=>'Only character and space is allowed',
                'techEmailid.required' =>'Email id is required',
                'techEmailid.regex'=>'Email id will be @nic.in or @gov.in',
                'techTelehponeNo.required' => 'Telephone No is required',
                'techTelehponeNo.regex' => 'Telephone No should be minimum 4 digits and maximum 8 digits',
                'techmobileNo.required' =>'Mobile No is required',
                'techmobileNo.regex' => 'Mobile No should be minimum 10 digits and should not start with 0',
                'techstdcode.required'=>'Please enter STD code',
                'techstdcode.regex'=>'STD code should be minimum 2 digits and maximum 4 digits',
                
            
            ]);
            
                if ($this->selectedMinistry == 14) {
                    $this->validate([
                        'techcountrydialcode' => ['required', 'regex:/^\+?[0-9]{1,4}$/'],
                    ], [
                        'techcountrydialcode.required' => 'Please enter country code',
                        'techcountrydialcode.regex' => 'Country code should be in format',
                    ]);
                }
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
                        'region' => $this->region ==1?'cu':$this->state_domain,
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

                    /**Add organisation if exixts */

                    if(!empty($this->addnewOrganisation)){

                        Organisation::insert([
                            'org_name'=> $this->addnewOrganisation,
                            'm_id'=>$this->selectedMinistry,
                            'dept_id'=>$this->selectedDepartment,
                            'orgcat_id'=>$this->selectedOrgcategory,
                            'state_utcode'=>$this->region == 2 ? $this->state_domain : 'cu',
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
                            'countryid' => 'India',
                            'pincode' => $this->orgPincode,
                            'telephone_std_code' => $this->orgstdcode,
                            'telephone' => $this->orgTelehponeNo,
                            'mobileno' => $this->orgmobileNo,
                            'email' => $this->orgemailid,
                         ]);

                        
                     //insert in Admin contacts
         
                   Contact::create([
                        'contactid'=>$admincontact,
                        'c_name' => $this->adminName,
                        'designation' => $this->adminDesignation,
                        'address1' => $this->adminAddress1,
                        'address2' => $this->adminAddress2,
                        'city' => $this->adminCity,
                        'state' => $this->adminState,
                        'countryid' => 'India',
                        'pincode' => $this->adminPincode,
                        'telephone_std_code' => $this->adminstdcode,
                        'telephone' => $this->adminTelehponeNo,
                        'mobileno' => $this->adminmobileNo,                    
                        'email' => $this->adminemailid
                    ]);


                    //insert in Technical contacts

                   Contact::create([
                        'contactid'=>$techcontact,
                        'c_name' => $this->techName,
                        'address1' => $this->techAddress1,
                        'address2' => $this->techAddress2,
                        'city' => $this->techCity,
                        'state' => $this->techState,
                        'countryid' => 'India',
                        'pincode' => $this->techPincode,
                        'telephone_std_code' => $this->techstdcode,
                        'telephone' => $this->techTelehponeNo,
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
            $this->isaddOrganisation = $getorgcatRow->add_organisation == 1 ? true : false;
            $this->isdepartmentVisible = $getorgcatRow->dept_is_visible == 1 ? true : false; 
            $this->selectedMinistry = null;
            $this->selectedDepartment = null;
            $this->selectedOrganisation = null;
            $this->departments = [];
            $this->organisations = [];
          
    
        }
    
       
        public function updatedSelectedMinistry($ministry)
        {

            $this->departments = Department::where('m_id','=',$ministry)->get();

            if(!$this->isdepartmentVisible){
                $this->organisations = Organisation::where('m_id', '=', $this->selectedMinistry)
                ->where('orgcat_id', '=', $this->selectedOrgcategory)->get();
            }else{
               $this->organisations = [];
               $this->selectedOrganisation = null;
            }
          
            $this->selectedDepartment = null;           
           
        }

        public function updatedselectedDepartment($department)
        {

           $query = Organisation::query();

            if ($department > 0 || $department != null) {
                $query->where('dept_id', '=', $department);
            }

            $query->where('m_id', '=', $this->selectedMinistry)
                ->where('orgcat_id', '=', $this->selectedOrgcategory);

            $this->organisations = $query->get();
                    
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
