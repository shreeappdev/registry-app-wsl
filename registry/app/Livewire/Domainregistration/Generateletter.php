<?php

namespace App\Livewire\Domainregistration;

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

class Generateletter extends Component
{


    public $totalStep = 2;
    public $currentStep = 1;
    public $domainid;
    public $officertype;
    public $nodaloffiers;
    public $nodalofficerid;

    #[Title('Generate Registration Letter')]
    public function mount()
    {

        $this->currentStep = 1;
    }

    public function increaseStep()
    {

        $this->resetErrorBag();
        $this->validateData();
        $this->currentStep++;

        if ($this->currentStep > $this->totalStep) {
            $this->currentStep = $this->totalStep;
        }

        if ($this->currentStep == 2) {

            $getdomainOrganisationDetails = Domain::where('domainid', '=', $this->domainid)->first();


            if ($getdomainOrganisationDetails->region == 1) {
                $this->nodaloffiers = NodalOfficers::where('fa_nodal', $this->officertype)
                    ->where('ministry', $getdomainOrganisationDetails->ministry)
                    ->where('is_active', 1)
                    ->where('region', 'central')
                    ->get();
            } else {
                $this->nodaloffiers = NodalOfficers::where('fa_nodal', $this->officertype)
                    ->where('ministry', $getdomainOrganisationDetails->state_utcode)
                    ->where('is_active', 1)
                    ->where('region', 'central')
                    ->paginate(20);
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
        if ($this->currentStep == 1) {

            $this->validate(
                [
                    'domainid' => 'required',
                ],
                [
                    'domainid.required' => 'Please choose domainname',
                ]
            );
        }
    }



    public function generateLetter()
    {

         
       
        $data__admin=[];
        $data__org=[];
        $this->validateData();
    
      
            // Prepare the data for the view
            $domaindetails = Domain::where('domainid', '=', $this->domainid)->first();
            $ministry = !empty($domaindetails->ministry) ? Ministry::where('m_id', $domaindetails->ministry)->first() : null;
            $orgcategory = !empty($domaindetails->orgcategory) ? Orgcategory::where('orgcatid', $domaindetails->orgcategory)->first() :null;

            $departmentdetails = !empty($domaindetails->dept) ? Department::where('id', $domaindetails->dept)->first() : null;
            $state = !empty($domaindetails->state_utcode) ? StateUt::where('state_utcode', $domaindetails->state_utcode)->first():null;
            $orgcontactDetails = !empty($domaindetails->companyid ) ? Contact::where('contactid', $domaindetails->companyid)->first():null;
            $admincontactDetails = !empty($domaindetails->adminid) ? Contact::where('contactid', $domaindetails->adminid)->first()  : null;
            $region = $domaindetails->region == 1 ? 'Central' : 'State';
            $organisationdetails = !empty($domaindetails->org_id) ? Organisation::where('org_id', $domaindetails->org_id)->first() : null;
             $idndomains = $domaindetails->has_idn > 0 ? Idndomain::where('master_domainid', $domaindetails->domainid)->get() : collect();

		     $all_idn_domains=  implode(',', $idndomains->pluck('domainname_decoded')->toArray());
             $nodalOfficer = !empty($this->nodalofficerid) ? NodalOfficers::where('faid', $this->nodalofficerid)->first()  :null;
        
           $nodalorgname =  !empty($nodalOfficer->org_id) ? Organisation::where('org_id', $nodalOfficer->org_id)->first():null;
           $nodalministry = !empty($nodalOfficer->ministry) ? Ministry::where('m_id', $nodalOfficer->ministry)->first():null;
           $nodaldept = !empty($nodalOfficer->department) ? Department::where('id', $nodalOfficer->department)->first():null;
           $nodaldesignation = !empty($nodalOfficer->designation)  ? Designation::where('id', $nodalOfficer->designation)->first():null;

			$contentforenglish=$domaindetails->lang == 'en' ? "<p>I formally request the administrative control of the 3rd level domain <strong>$domaindetails->domainname</strong> to designate domain owning organization to subsequently handle sub-domain registrations.</p>:":"";
                
		    $ministry_dept_org_name=""; 
		   if($nodalOfficer->state_utcode =='cu'){
			if($nodalOfficer->ministry == 58 && $nodalOfficer->department == 0){
				$ministry_dept_org_name = !empty($nodalorgname) ? $nodalorgname->org_name : "No Organisation Name";
			
			}elseif($nodalOfficer->ministry == 58 && $nodalOfficer->department > 0){
				$ministry_dept_org_name= !empty($nodaldept) ? $nodaldept->name : "No Department";
			}elseif($nodalOfficer->ministry > 0 && $nodalOfficer->ministry != 58 ){

				if( $nodalOfficer->department > 0){
					$ministry_dept_org_name .= ",{$nodaldept->name}";
				}
				if($nodalOfficer->org_id > 0){
					
					$ministry_dept_org_name.= "({$nodalorgname->org_name})";
				
				}else{
					$ministry_dept_org_name="--";
				}			
			}
		}
             //get IDN domain details

            if (empty($orgcontactDetails)) {

               session()->flash('failed','There is some error with domain contact details');

            } else {

                $data__org = [

                    'organisationPersonName' => $orgcontactDetails->c_name ?? "No Organisation Contact Person",
                    'organisationAddress' => $orgcontactDetails->address ??  "No Organisation Address",
                    'organisationCity' => $orgcontactDetails->city ??  "No Organisation City",
                    'organisationState' => $orgcontactDetails->state ??  "No Organisation State",
                    'organisationPincode' => $orgcontactDetails->pincode ??  "No Organisation Pincode",
                    'organisationTelephone' => $orgcontactDetails->telephone ??  "No Organisation Telephone",
                    'organisationEmail' => $orgcontactDetails->email ??  "No Organisation Email",
                ];
            }


            if (empty($admincontactDetails)) {

                session()->flash('failed','There is some error with domain contact details');
            } else {

                $data__admin = [
                    'adminPersonName' => $admincontactDetails->c_name ??  "No Admin Contact Person",
                    'adminAddress' => $admincontactDetails->address ??  "No Admin Address",
                    'adminCity' => $admincontactDetails->city ??  "No Admin City",
                    'adminState' => $admincontactDetails->state ??  "No Admin State",
                    'adminPin' => $admincontactDetails->pincode ??  "No Admin Pincode",
                    'adminTelephone' => $admincontactDetails->telephone ?? "No Admin Telephone",
                    'adminEmail' => $admincontactDetails->email ??  "No Admin Email",
                ];
            }

            if(!empty($nodalOfficer)){

                  $nodal_details = [

                    'nodal_name' => $nodalOfficer->name ??  "No Nodal Officer",
                    'nodal_designation' => $nodaldesignation->designation ??  "No Designation",
                    'nodal_email' => $nodalOfficer->email ?? "No Email",
                    'nodal_ministry' => !empty($nodalministry) ? $nodalministry->m_name  : "No Ministry",
                    'nodal_region' => $nodalOfficer->region ?? "No Region",
                    'nodal_dept' => !empty($nodaldept) ? $nodaldept->name : "No Department",
                    'nodal_organisation' =>  $nodalorgname->org_name ?? "No Organisation Name",
                    'ministry_dept_org_name' => $ministry_dept_org_name,
                    'contentforenglish' => $contentforenglish ?? "No Content"
                  ];
            }else{
                 session()->flash('failed','There is some error with domain contact details');
            }
        

        $data = [
            'title' => 'Registration Letters(Annex-1, Annex2)',
            'date' => date('m/d/Y'),
            'domain_name' => $domaindetails->domainname,
            'orgcategory' => $orgcategory->orgcat ?? 'No Orgcategory',
            'ministry' => $ministry->m_name ?? 'No Ministry',
            'department' => !empty($domaindetails->dept) ? $departmentdetails->name : "No Department",
            'state' => $domaindetails->region==2  ? $state->state_utname :"",
            'region' => $region,
            'organisationName' => !empty($domaindetails->org_id) ? $organisationdetails->org_name : "No Organisation",
            'idn_domain_name' => $all_idn_domains,
        ];
       

        if(empty($data__admin) || empty($data__org)){

            session()->flash('failed','There is some error with domain contact details');

        }else{

            // Load the view and pass the data to it
            $pdf1 = Pdf::loadView('livewire.Letterformat.domainregistration-anex1', array_merge($data, $data__admin, $data__org));
            $pdf2 = Pdf::loadView('livewire.Letterformat.domainregistration-anex2', array_merge($data, $nodal_details));
            $randomNumber = CustomHelper::generateCode();

            $filename1 = $domaindetails->domainname.$randomNumber.'_annex1.pdf';
            $filename2 = $domaindetails->domainname.$randomNumber.'_annex2.pdf';

            // Save the PDF in the public storage folder
            $path1 = storage_path("app/public/registrationletters/{$filename1}");
            $pdf1->save($path1);

            $path2 = storage_path("app/public/registrationletters/{$filename2}");
            $pdf2->save($path2);

            $link1 = Storage::url("registrationletters/{$filename1}");
            $link2 = Storage::url("registrationletters/{$filename2}");

            $this->dispatch('regletterGenerated',type:'success',title:'Letter Generated',text:$domaindetails->domainname,date:date('Y-m-d'),html:"<p>Annexure I and II has been generated successfully.<br><a href=$link1 target='_blank'>Download the Annexure I</a> <br><a href=$link2 target='_blank'>Download the Annexure I</a></p>");
        }
        
    }

    public function render()
    {

        $domains = Domain::all();
        return view('livewire.domainregistration.generateletter', ['domains' => $domains]);
    }
}
