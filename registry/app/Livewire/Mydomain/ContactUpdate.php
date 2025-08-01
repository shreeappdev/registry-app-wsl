<?php

namespace App\Livewire\Mydomain;

use App\Models\Domain;
use App\Models\Contact;
use Livewire\Component;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\DB;

class ContactUpdate extends Component
{


    public $name;
    public $designation;
    public $address1;
    public $countryid;
    public $city;
    public $state;
    public $pincode;
    public $telephoneno;
    public $stdcode;
    public $mobileno;
    public $emailid;
    public $item;
    public $domain;
    public $contactid;
    public $ctype;
    public $selectedMinistry;
    public $countrydialcode;

    #[Title('My Domain')]
    public function mount($id,$domain,$ctype)
    { 
      
        $this->contactid = $id;
        $this->ctype = $ctype;
        $domaindetails = Domain::where('domainid', $domain)->first();
        if (empty($domaindetails)) {
            session()->flash('error', 'Domain not found');
            return redirect(route('domain_status'));
        }

        $existingContact = DB::table('mod_contacts')->where('contactid',"=",$id)->first();

        if (empty($existingContact)){
            $this->item = Contact::where('contactid',"=",$id)->first();
        }else{
            $this->item = $existingContact;
        }
    

        $this->name = $this->item->c_name;
        $this->designation = $this->item->designation;
        $this->mobileno = $this->item->mobileno;
        $this->emailid = $this->item->email;
        $this->pincode = $this->item->pincode;
        $this->address1 = $this->item->address1;
        $this->selectedMinistry = $domaindetails->ministry;
        $this->telephoneno = $this->item->telephone;
        $this->stdcode = $this->item->telephone_std_code;
        $this->countrydialcode = $this->item->country_dial_code;
        $this->city = $this->item->city;
        $this->domain=$domain;
        

    }

    public function validateData(){
        $this->validate([
            'name'=>'required|min:5',
            'designation'=>['required','regex:/^[a-zA-Z\s]+$/'],
            'mobileno'=>['required','regex:/^(\+?\d{1,3})?\d{10}$/'],
            'emailid'=>['required','regex:/^[a-zA-Z0-9_.+-]+@(?:(?:[a-zA-Z0-9-]+\.)?[a-zA-Z0-9-]+\.)?(nic|gov)\.in$/'],
            'city'=>['required','regex:/^[a-zA-Z\s]+$/'],
            'state'=>'required',
            'pincode'=>'required |min:6 |numeric',
            'telephoneno'=>'required|regex:/^[0-9]{4,8}+$/',
            'stdcode'=>'required|regex:/^[0-9]{2,4}+$/',
            'address1'=>'required'
        
        ],
        [
            'name.required' => 'Name is required',
            'designation.required' => 'Designation is required',
            'designation.regex'=>'Only character and space is allowed',
            'city.required' => 'City is required',
            'state.required' => 'State is required',
            'pincode.required' => 'Pincode is required',
            'pincode.min'=>'Pincode should be 6 digits',
            'pincode.numeric'=>'Pincode should be numeric',
            'telephoneno.required' => 'Telephone No is required',
            'telephoneno.regex'=>'Telephone No should be 4 to 8 digits',
            'mobileno.required' =>'Mobile No is required',
            'mobileno.regex'=>'Mobile No should be 10 digits',
            'address1.required' =>'Address is required',
            'emailid.required' =>'Email id is required',
            'emailid.regex'=>'Email id will be @nic.in or @gov.in',
            'stdcode.required'=>'Please enter STD code',
            'stdcode.regex'=>'STD code should be 2 to 4 digits',
        ]);

    }

    public function update(){

        $this->validateData();
        try{
        $existingmodContact = DB::table('mod_contacts')->where('contactid',"=",$this->contactid)->get();
        $ifExists = $existingmodContact->count();
          $datatoChange= [
            'c_name' => $this->name,
            'designation' => $this->designation,
            'city' => $this->city,
            'contactid' => $this->contactid,
            'mobileno'=>$this->mobileno,
            'email'=>$this->emailid,
            'pincode'=>$this->pincode,
            'address1'=>$this->address1,
            'state'=>$this->state,
            'countryid'=>$this->countryid,  
            'telephone_std_code'=>$this->stdcode, 
            'country_dial_code'=>$this->countrydialcode, 
            'telephone'=>$this->telephoneno,
            'city'=> $this->city,
            'domainid'=>$this->domain,
            'contact_type'=> $this->ctype,
            'req_type'=>2

           ];
        if($ifExists > 0){
            DB::table('mod_contacts')
            ->where('contactid', $this->contactid)
            ->update($datatoChange);
            // session()->flash('message', 'Contact update request submitted. It will be approved and reflected soon');
            // return redirect(route('single-domain',['domainid'=>$this->domain]));

            
            $this->dispatch('contactrequestsubmitted',icon:'success',title:'Request Submitted',html:"<p>Contact update request submitted. It will be approved and reflected soon.</p></div>");

        }else{
           DB::table('mod_contacts')
            ->insert($datatoChange);
        
            // session()->flash('message', 'Contact update request submitted ');
            // return redirect(route('my_domains'));

               $this->dispatch('contactrequestsubmitted',icon:'success',title:'Request Submitted',html:"<p>Contact update request submitted. It will be approved and reflected soon.</p></div>");
        }
    }catch(\Exception $e){
         $this->dispatch('contactrequestFailed',icon:'falied',title:'Request Not submitted for some technical issue',html:"<p>Contact Support.</p></div>");
    }
   }


    public function render()
    {

        $states = DB::table('state_ut')->get();
        return view('livewire.mydomain.contact-update',[ 'states'=>$states,'domainid' => $this->domain]);
    }
}
