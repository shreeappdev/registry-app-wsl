<?php

namespace App\Livewire\Domainregistration;

use App\Models\Domain;
use App\Models\Contact;
use App\Models\StateUt;
use Livewire\Component;
use App\Models\Ministry;
use App\Models\Department;
use App\Models\Orgcategory;
use App\Models\NodalOfficers;
use Livewire\Attributes\Title;
use Barryvdh\DomPDF\Facade\PDF;

class Generateletter extends Component
{


    public $totalStep = 2;
    public $currentStep = 1;
    public $domainid;
    public $officertype;
    public $nodaloffiers;
    public $nodalofficerid;

    #[Title('Subdomain Registration')]
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



    public function geneerateLetter()
    {
       
        $data__admin=[];
        $data__org=[];
        $this->validateData();
      
            // Prepare the data for the view
            $domaindetails = Domain::where('domainid', '=', $this->domainid)->first();
            $ministry = !empty($domaindetails->ministry) ? Ministry::where('m_id', $domaindetails->ministry)->first() : "No ministry";
            $orgcategory = !empty($domaindetails->orgcategory) ? Orgcategory::where('orgcatid', $domaindetails->orgcategory)->first() : "No Organisation Category";

            $departmentdetails = !empty($domaindetails->dept) ? Department::where('id', $domaindetails->dept)->first() : "No department";
            $state = StateUt::where('state_utcode', $domaindetails->state_utcode)->first();
            $orgcontactDetails = Contact::where('contactid', $domaindetails->companyid)->first()? : [];
            $admincontactDetails = Contact::where('contactid', $domaindetails->adminid)->first()? : [];
            $region = $domaindetails->region == 1 ? 'Central' : 'State';
            $organisationdetails = !empty($domaindetails->org_id) ? Department::where('org_id', $domaindetails->org_id)->first() : "No Organistion Name";

            if (empty($orgcontactDetails)) {

               session()->flash('failed','There is some error with domain contact details');
            } else {

                $data__org = [

                    'organisationPersonName' => $orgcontactDetails->c_name,
                    'organisationOrgName' => $orgcontactDetails->organisation,
                    'organisationAddress' => $orgcontactDetails->address,
                    'organisationCity' => $orgcontactDetails->city,
                    'organisationState' => $orgcontactDetails->state,
                    'organisationPincode' => $orgcontactDetails->pincode,
                    'organisationTelephone' => $orgcontactDetails->telephone,
                    'organisationEmail' => $orgcontactDetails->email
                ];
            }


            if (empty($admincontactDetails)) {

                session()->flash('failed','There is some error with domain contact details');
            } else {

                $data__admin = [
                    'adminPersonName' => $admincontactDetails->c_name,
                    'adminOrgName' => $admincontactDetails->organisation,
                    'adminAddress' => $admincontactDetails->address,
                    'adminCity' => $admincontactDetails->city,
                    'adminState' => $admincontactDetails->state,
                    'adminPin' => $admincontactDetails->pincode,
                    'adminTelephone' => $admincontactDetails->telephone,
                    'adminEmail' => $admincontactDetails->email,
                ];
            }
        



        $data = [
            'title' => 'Registration Letters(Annex-1, Annex2)',
            'date' => date('m/d/Y'),
            'domain_name' => $domaindetails->domainname,
            'orgcategory' => $orgcategory->orgcat,
            'ministry' => $ministry->m_name,
            'department' => !empty($domaindetails->dept) ? $departmentdetails->name : "No Department",
            'state' => $state->state_utname,
            'region' => $region,
            'organisationName' => !empty($domaindetails->org_id) ? $organisationdetails->org_name : "No Organisation",
        ];
       

        if(empty($data__admin) || empty($data__org)){


            session()->flash('failed','There is some error with domain contact details');

        }else{

            // Load the view and pass the data to it
            $pdf = PDF::loadView('livewire.userdashboard.domainregistration.letterformat', array_merge($data, $data__admin, $data__org));

            // Return the generated PDF for download or inline display
            // return $pdf->download('document.pdf');
            // Or to display inline in the browser: return $pdf->stream();
            $filename = $this->domainid.'letter.pdf';


        
            // Save the PDF in the public storage folder
            $path = storage_path("app/public/{$filename}");
            $pdf->save($path);

            $this->dispatch('regletterGenerated',type:'success',title:'Letter Generated',text:$domaindetails->domainname,date:date('Y-m-d'),html:"<p>Annexure I and II has been generated successfuly.Download the lettes</p>");
        }
        
    }

    public function render()
    {

        $domains = Domain::all();
        return view('livewire.domainregistration.generateletter', ['domains' => $domains]);
    }
}
