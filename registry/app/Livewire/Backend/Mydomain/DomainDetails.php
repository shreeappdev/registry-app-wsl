<?php

namespace App\Livewire\Mydomain;

use App\Models\Domain;
use App\Models\Contact;
use Livewire\Component;
use App\Models\Ministry;
use App\Models\Department;
use App\Models\Organisation;
use Livewire\Attributes\Title;
use App\Models\Nameserver_data;
use Illuminate\Support\Facades\DB;

class DomainDetails extends Component
{


    public $domainid;
    public function mount(){
       $this->domainid;

    }

    #[Title('Domain Details')]
    public function render()
    {


        $domaindetails=Domain::where('domainid',$this->domainid)->first();
        // $existingmodContact = DB::table('mod_contacts')->where('domainid',"=",$this->domainid)
        //                         ->where('approved','P')->count();

   
             $orgcontactDetails = DB::table('mod_contacts')->where([
                ['contactid', '=', $domaindetails->companyid],
                ['approved', '=', 'P'],
                ['domainid', '=', $this->domainid]
            ])->first() ?? [];
        
            $ifexistsOrgcontact =!empty($orgcontactDetails) ? 1 :0;

            $adminContactDetails = DB::table('mod_contacts')->where([
                ['contactid', '=', $domaindetails->adminid],
                ['approved', '=', 'P'],
                ['domainid', '=', $this->domainid]
            ])->first() ?? [];

            
            $ifexistsadmincontact  =!empty($adminContactDetails) ? 1 :0;

            $techContactDetails = DB::table('mod_contacts')->where([
                ['contactid', '=', $domaindetails->techid],
                ['approved', '=', 'P'],
                ['domainid', '=', $this->domainid]
            ])->first() ?? [];

            $ifexiststechcontact =!empty($techContactDetails) ? 1 : 0;
        
                              
        $data=[
         'domaindetails'=>$domaindetails,
         'ministry'=>Ministry::where('m_id',$domaindetails->ministry)->first() ? : [],
         'department'=>Department::where('id',$domaindetails->dept)->first() ? : [],
         'corgcontactdetails'=> $ifexistsOrgcontact ==1 ? $orgcontactDetails : Contact::where('contactid',$domaindetails->companyid)->first(),
         'admincontactDetails'=> $ifexistsadmincontact == 1 ? $adminContactDetails :  Contact::where('contactid',$domaindetails->adminid)->first(),
         'techcontactDetails'=>  $ifexiststechcontact ==1 ? $techContactDetails : Contact::where('contactid',$domaindetails->techid)->first(),
         'organisationdetails'=>Organisation::where('org_id',$domaindetails->org_id)->first() ? : [],
         'region'=>$domaindetails->region,
         'nameservers_current_data'=>Nameserver_data::where('domainid',$domaindetails->domainid)->first() ? : [],
 
        ];
        
       
         return view('livewire.mydomain.domain-details',['data' => $data,'orgcontactCount'=> $ifexistsOrgcontact,'admincontactCount'=>  $ifexistsadmincontact,'techcontactCount'=>$ifexiststechcontact]);
    }
}
