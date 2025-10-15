<?php

namespace App\Livewire\Backend\Domainregistration;

use App\Models\Domain;
use App\Models\Contact;
use App\Models\StateUt;
use Livewire\Component;
use App\Models\Ministry;
use App\Models\Idndomain;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Orgcategory;
use App\Models\Organisation;
use App\Helpers\CustomHelper;
use App\Models\NodalOfficers;
use Livewire\Attributes\Title;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use App\Helpers\Customdbresults;

class Generateletter extends Component
{

    public $userId = 1;
    // public $letterType = 'nodal';
    public $totalStep = 2;
    public $currentStep = 1;
    public $domainid;
    public $officertype;
    public $nodalofficers;
    public $nodalofficerid;
    public $newNodalName;
    public $newNodalEmail;
    public $selectedNewNodalDesg; 
   // protected $queryString = ['domainid', 'letterType'];
    public $isNewNodal = false;
    public $newNodalDetails = [];


    #[Title('Generate Registration Letter')]
    public function mount()
    {
       // $this->letterType = $letterType;
        // $this->domainid = $domainid;
        $this->currentStep = 1;
    }

    public function increaseStep()
    {

        $this->resetErrorBag();
        $this->validateData();
        $this->currentStep++;
       //dd($this->currentStep);
        if ($this->currentStep > $this->totalStep) {
            $this->currentStep = $this->totalStep;
        }

        if ($this->currentStep == 2) {

            $getdomainOrganisationDetails = Domain::where('domainid', '=', $this->domainid)->first();
           //dd($getdomainOrganisationDetails);

            if ($getdomainOrganisationDetails->region == 1) {
                
                // $this->nodalofficers = NodalOfficers::where('fa_nodal', $this->officertype)
                //     ->where('ministry', $getdomainOrganisationDetails->ministry)
                //     ->where('department', $getdomainOrganisationDetails->dept)
                //     ->where('org_id', $getdomainOrganisationDetails->org_id)
                //     ->where('is_active', 1)
                //     ->where('region', 'central')
                //     ->get();



                $this->nodalofficers = NodalOfficers::with(['minDetails', 'deptDetails','orgDetails'])
                ->when($this->officertype, function($q) {
                    $q->where('fa_nodal', $this->officertype);
                })
                ->when($getdomainOrganisationDetails->ministry && $getdomainOrganisationDetails->ministry != 0, function ($q) use ($getdomainOrganisationDetails) {
                    $q->where('ministry', (int) $getdomainOrganisationDetails->ministry);
                })
                ->when($getdomainOrganisationDetails->dept && $getdomainOrganisationDetails->dept != 0, function ($q) use ($getdomainOrganisationDetails) {
                    $q->where('department', (int) $getdomainOrganisationDetails->dept);
                })
                ->when($getdomainOrganisationDetails->org_id && $getdomainOrganisationDetails->org_id != 0, function ($q) use ($getdomainOrganisationDetails) {
                    $q->where('org_id', (int) $getdomainOrganisationDetails->org_id);
                })
                ->where('is_active', 1)
                ->where('region', 'central')
                ->get();

               // dd($this->nodalofficers->toArray());




           
            } else {
                $this->nodalofficers = NodalOfficers::where('fa_nodal', $this->officertype)
                    ->where('state_utcode', $getdomainOrganisationDetails->state_utcode)
                   // ->where('org_id', $getdomainOrganisationDetails->org_id)
                    ->where('is_active', 1)
                    ->where('region', 'state')
                    ->get();
                   // ->paginate(20);
                  //  dd('esle',count($this->nodalofficers) ,$getdomainOrganisationDetails);

                    // $this->nodalofficers = NodalOfficers::with(['organisationDetails'])
                    // ->where('fa_nodal', $this->officertype)
                    // ->where('state_utcode', $getdomainOrganisationDetails->state_utcode)
                    // ->where('org_id', $getdomainOrganisationDetails->org_id)
                    // ->where('is_active', 1)
                    // ->where('region', 'state')
                    //  ->get();
                    
            }
        }
    }

    
    public function decreaseStep(){
        $this->resetErrorBag();
        $this->currentStep--;
        if($this->currentStep < 1){
            $this->currentStep = 1;
        }
    }

    public function validateData()
    {          
        if($this->isNewNodal && $this->officertype == 'non-nodal'){
            $this->validate(
                [
                    'newNodalName'=>['required','max:200','regex:/^[a-zA-Z\s]+$/'],
                    'selectedNewNodalDesg'=>'required',
                    'newNodalEmail'=>['required','regex:/^[a-zA-Z0-9_.+-]+@(?:(?:[a-zA-Z0-9-]+\.)?[a-zA-Z0-9-]+\.)?(nic|gov)\.in$/'],
                ],
                [
                    'newNodalName.required' => 'Name is required',
                    'newNodalName.regex'=>'Only character and space is allowed',
                    'selectedNewNodalDesg.required' => 'Designation is required',
                    'newNodalEmail.required' =>'Email id is required',
                    'newNodalEmail.regex'=>'Email id will be @nic.in or @gov.in',              
                ]
            );
        }
        elseif($this->currentStep == 1) {

            $this->validate(
                [
                    'domainid' => 'required',
                    'officertype' => 'required'
                ],
                [
                    'domainid.required' => 'Please choose domainname',
                    'officertype.required' => 'Please choose Sign By.'
                ]
            );
        }elseif($this->currentStep == 2){
             $this->validate(['nodalofficerid' => 'required',],['nodalofficerid.required' => 'Please Select officer.', ] );
        }
    }

    public function generateLetter()
    {
       
        $this->validateData();

        $domainDetails = Customdbresults::domainDetails($this->domainid,['minDetails', 'orgcatDetails', 'deptDetails', 'stateDetails', 'orgDetails', 'orgContactDetails', 'adminContactDetails','idnDomainDetails']);
        if( empty( $domainDetails) || empty( $domainDetails->orgContactDetails) || empty( $domainDetails->adminContactDetails) ){
            return session()->flash('failed','There is some error with domain contact details');
        } 

         /* Add Non nodal officers st  */
        if ($this->isNewNodal) {
            $newNodal =  NodalOfficers::create([                 
                'fa_nodal' => $this->officertype,
                'ministry' =>$domainDetails->ministry ?? 0,
                'department' => $domainDetails->dept ?? 0,
                'region' => $domainDetails->region == 1 ? 'central' : 'state',
                'state_utcode' =>  $domainDetails->state_utcode ?? 0,
                'name' =>  $this->newNodalName,
                'org' => '',
                'designation' => $this->selectedNewNodalDesg,
                'email' =>  $this->newNodalEmail,
                'by_regid' => $this->userId,                    
                'is_active' => 1,
                'show_nodal'=>1,
                'org_id' =>$domainDetails->org_id ?? 0               
            ]);

            $this->nodalofficerid = $newNodal->faid;
        }
        /* Add Non nodal officers cl  */
        $nodalOfficer = Customdbresults::nodalOfficersDetails($this->nodalofficerid, ['minDetails', 'deptDetails', 'orgDetails', 'DesgDetails']);
        if(empty( $nodalOfficer)) return session()->flash('failed','There is some error with domain contact details');
            
		$contentforenglish=$domainDetails->lang == 'en' ? "<p>I formally request the administrative control of the 3rd level domain <strong>$domainDetails->domainname</strong> to designate domain owning organization to subsequently handle sub-domain registrations.</p>":"";
        $organisationName  = optional($domainDetails->orgDetails)->org_name
                            ?? optional($domainDetails->deptDetails)->name
                            ?? optional($domainDetails->minDetails)->m_name
                            ?? 'No Organization.';

        $nodal_details = [
            'nodal_name' => $nodalOfficer->name ??  "N/A",
            'nodal_designation' => !empty($nodalOfficer->DesgDetails)?$nodalOfficer->DesgDetails->designation :  "N/A",
            'nodal_email' => $nodalOfficer->email ?? "N/A",
            'nodal_ministry' => !empty($nodalOfficer->minDetails) ? $nodalOfficer->minDetails->m_name  : "N/A",
            'nodal_region' => $nodalOfficer->region ?? "N/A",
            'nodal_dept' => !empty($nodalOfficer->deptDetails) ? $nodalOfficer->deptDetails->name : "N/A",
            'nodal_organisation' =>  !empty($nodalOfficer->orgDetails)?$nodalOfficer->orgDetails->org_name : "N/A",
            'contentforenglish' => $contentforenglish ?? "N/A"
        ];
            
        $data = [
            'title' => 'Registration Letters(Annex-1, Annex2)',
            'date' => date('m/d/Y'),
            'domainDetails' => $domainDetails,
            'domain_name' => $domainDetails->dname_decoded_punycode,
            'orgcategory' => !empty($domainDetails->orgcatDetails)?$domainDetails->orgcatDetails->orgcat : 'N/A',
            'ministry' => !empty($domainDetails->minDetails) ? $domainDetails->minDetails->m_name : 'N/A',
            'department' => !empty($domainDetails->deptDetails) ? $domainDetails->deptDetails->name : 'N/A',
            'state' => ($domainDetails->region==2 && !empty($domainDetails->stateDetails))  ? $domainDetails->stateDetails->state_utname :"",
            'region' => $domainDetails->region == 1 ? 'Central' : 'State',
            'organisationName' => $organisationName,
            'idn_domain_name' => !empty($domainDetails->idnDomainDetails)?$domainDetails->idnDomainDetails->domainname_decoded:'N/A',
            
        ];

        $pdf1 = Pdf::loadView('livewire.Letterformat.domainregistration-anex1', $data);
        $pdf2 = Pdf::loadView('livewire.Letterformat.domainregistration-anex2', array_merge($data, $nodal_details));
        $randomNumber = CustomHelper::generateCode();

        $filename1 = $domainDetails->domainname.$randomNumber.'_annex1.pdf';
        $filename2 = $domainDetails->domainname.$randomNumber.'_annex2.pdf';

        
        $path1 = storage_path("app/public/registrationletters/{$filename1}");
        $pdf1->save($path1);

        $path2 = storage_path("app/public/registrationletters/{$filename2}");
        $pdf2->save($path2);

        $link1 = Storage::url("registrationletters/{$filename1}");
        $link2 = Storage::url("registrationletters/{$filename2}");
        

        $this->dispatch('regletterGenerated', [
            'type'  => 'success',
            'title' => 'Letter Generated',
            'text'  => $domainDetails->domainname,
            'date'  => now()->format('Y-m-d'),
            'html'  => "<p>Annexure I and II has been generated successfully.<br>
                        <a href='{$link1}' target='_blank'>Download the Annexure I</a><br>
                        <a href='{$link2}' target='_blank'>Download the Annexure II</a>
                        </p>",
        ]);           
    }

    public function addNewNodal(){
        $this->isNewNodal = true;
        $domainDetails = Customdbresults::domainDetails($this->domainid,['minDetails', 'orgcatDetails', 'deptDetails', 'stateDetails', 'orgDetails']);            
        if( empty($domainDetails) ) return session()->flash('failed','There is some error with domain contact details');
         $region = $domainDetails->region == 1 ? 'central' : 'state';
        $designations = Designation::where('region',$region)->where('allowfor_registartion',1)->get();
 
        $this->newNodalDetails = [
            'ministry' => !empty($domainDetails->minDetails)? $domainDetails->minDetails->m_name :'',
            'department'=> !empty($domainDetails->deptDetails)? $domainDetails->deptDetails->name :'',
            'state'=> (!empty($domainDetails->stateDetails) &&  $domainDetails->region == 2)? $domainDetails->stateDetails->state_utname :'',
            'organisation'=> !empty($domainDetails->orgDetails)? $domainDetails->orgDetails->org_name :'',
            'designations'=>$designations
        ];
    }
    
    public function render()
    {
        // if ($this->letterType === 'non-nodal') {
        //     $domaindetails = Domain::where('domainid', '=', $this->domainid)->first();
        //     $ministry = !empty($domaindetails->ministry) ? Ministry::where('m_id', $domaindetails->ministry)->value('m_name') : null;
        //     $department = !empty($domaindetails->dept) ? Department::where('id', $domaindetails->dept)->value('name') : null;
        //     $state = !empty($domaindetails->state_utcode) ? StateUt::where('state_utcode', $domaindetails->state_utcode)->value('state_utname'):null;
        //     $region = $domaindetails->region == 1 ? 'central' : 'state';
        //     $organisation = !empty($domaindetails->org_id) ? Organisation::where('org_id', $domaindetails->org_id)->value('org_name') : null;
        //     $designations = Designation::where('region',$region)->where('allowfor_registartion',1)->get();
        //  //   dd($designations);

        //     //dd($ministry,$department,$organisation,$state,$region);
        //     $data = [
        //         'ministry'=>$ministry,
        //         'department'=>$department,
        //         'state'=>$state,
        //         'organisation'=>$organisation,
        //         'designations'=>$designations
        //     ];
        //     return view('livewire.domainregistration.generateletter_nonnodal',$data);
        // }
        $domains = Domain::all();
        return view('livewire.domainregistration.generateletter', ['domains' => $domains]);
    }
}
