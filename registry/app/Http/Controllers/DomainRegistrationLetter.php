<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Domain;
use App\Models\Contact;
use App\Models\StateUt;
use App\Models\Ministry;
use App\Models\Department;
use App\Models\Orgcategory;
use Illuminate\Http\Request;
use App\Models\NodalOfficers;


class DomainRegistrationLetter extends Controller
{
 
    public static function getDomains(){

        $domains=Domain::all();
        return view('userdashboard.domainregistration.generateletter', compact('domains'));
    }
    
    public static function getNodalNonnodalOfficer(Request $request){
      
      
            $validated= $request->validate([
                'domainid' => 'required',
            ], 
            [
                'domainid.required' => 'Please choose domainname',
            ]);
   
        if($validated){
            $getdomainOrganisationDetails= Domain::where('domainid','=',$request->domainid)->first();

            if($getdomainOrganisationDetails->region == 1){
                $nodaloffiers=NodalOfficers::where('fa_nodal',$request->officertype)                                      
                                        ->where('ministry',$getdomainOrganisationDetails->ministry)
                                        ->where('is_active',1)
                                        ->where('region','central')
                                        ->get();
            }else{
                $nodaloffiers=NodalOfficers::where('fa_nodal',$request->officertype)
                                            ->where('ministry',$getdomainOrganisationDetails->state_utcode)
                                            ->where('is_active',1)
                                            ->where('region','central')
                                            ->paginate(20);
            }
        $domains=Domain::all();
        $domainid=$request->domainid;
        return view('userdashboard.domainregistration.nodalofficers', compact('nodaloffiers','domains','domainid'));
        }
       

    }

    public function generatePDF(Request $request){
            //validate data try {
       
            $validated= $request->validate([
                'domainid' => 'required',
            ], 
            [
                'domainid.required' => 'Please choose domainname',
            ]);
            
            if( $validated){
        
            // Prepare the data for the view
            $domaindetails= Domain::where('domainid','=',$request->domainid)->first();
            $ministry= !empty($domaindetails->ministry) ? Ministry::where('m_id',$domaindetails->ministry)->first() :"No ministry";
            $orgcategory=!empty($domaindetails->orgcategory) ? Orgcategory::where('orgcatid',$domaindetails->orgcategory)->first() : "No Organisation Category";

            $departmentdetails= !empty($domaindetails->dept) ? Department::where('id',$domaindetails->dept)->first() : "No department";
            $state= StateUt::where('state_utcode',$domaindetails->state_utcode)->first();
            $orgcontactDetails= Contact::where('contactid',$domaindetails->companyid)->first();
            $admincontactDetails= Contact::where('contactid',$domaindetails->adminid)->first();
            $region=$domaindetails->region == 1 ? 'Central' : 'State';
            $organisationdetails=!empty($domaindetails->org_id) ? Department::where('org_id',$domaindetails->org_id)->first() : "No Organistion Name";

            if (!$orgcontactDetails) {

                return response()->json([
                    'success' => false,
                    'message' => 'There is some issue with domain details', 
                   ]);

            }else{

                $data__org =[
            
                    'organisationPersonName'=>$orgcontactDetails->c_name,
                    'organisationOrgName'=>$orgcontactDetails->organisation,
                    'organisationAddress'=>$orgcontactDetails->address,
                    'organisationCity'=>$orgcontactDetails->city,
                    'organisationState'=>$orgcontactDetails->state,
                    'organisationPincode'=>$orgcontactDetails->pincode,
                    'organisationTelephone'=>$orgcontactDetails->telephone,
                    'organisationEmail'=>$orgcontactDetails->email
                ];
            }

            if (!$admincontactDetails) {

               return response()->json([
                'success' => false,
                'message' => 'There is some issue with domain details', 
               ]);
            }else{

                $data__admin=[
                    'adminPersonName'=>$admincontactDetails->c_name,
                    'adminOrgName'=>$admincontactDetails->organisation,
                    'adminAddress'=>$admincontactDetails->address,
                    'adminCity'=>$admincontactDetails->city,
                    'adminState'=>$admincontactDetails->state,
                    'adminPin'=>$admincontactDetails->pincode,
                    'adminTelephone'=>$admincontactDetails->telephone,
                    'adminEmail'=>$admincontactDetails->email,
                ];
            }

            }

           
        
        $data = [
            'title' => 'Registration Letters(Annex-1, Annex2)',
            'date' => date('m/d/Y'),
            'nodalofficerid'=>$request->nodalofficerid,
            'domain_name'=>$domaindetails->domainname,
            'orgcategory'=>$orgcategory->orgcat,
            'ministry'=> $ministry->m_name,
            'department'=> !empty($domaindetails->dept) ? $departmentdetails->name : "No Department",
            'state'=> $state->state_utname,
            'region'=>$region,
            'organisationName'=>!empty($domaindetails->org_id) ? $organisationdetails->org_name : "No Organisation",
        ];
        

        // Load the view and pass the data to it
        $pdf = PDF::loadView('userdashboard.domainregistration.letterformat', array_merge($data,$data__admin,$data__org));

        // Return the generated PDF for download or inline display
        // return $pdf->download('document.pdf');
        // Or to display inline in the browser: return $pdf->stream();
        $filename = 'example.pdf';
            
        // Save the PDF in the public storage folder
        $path = storage_path("app/public/{$filename}");
        $pdf->save($path);
        
        // Return the URL to the generated PDF
        return response()->json(['pdf_url' => asset("storage/{$filename}")]);

   
    }

}

