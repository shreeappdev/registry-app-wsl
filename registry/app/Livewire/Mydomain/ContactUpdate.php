<?php

namespace App\Livewire\Mydomain;

use App\Models\Contact;
use Livewire\Component;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\DB;

class ContactUpdate extends Component
{


    public $name;
    public $designation;
    public $address1;
    public $address2;
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

    #[Title('My Domain')]
    public function mount($id,$domain,$ctype)
    { 
      
        $this->contactid = $id;
        $this->ctype = $ctype;

        $existingContact = DB::table('mod_contacts')->where('contactid',"=",$id)->first();

        if (empty($existingContact)){
            $this->item = Contact::where('contactid',"=",$id)->first();
        }else{
            $this->item = $existingContact;
        }
    

        $this->name = explode(",",$this->item->c_name)[0];
        $this->designation = explode(",",$this->item->c_name)[1];
        $this->mobileno = $this->item->mobileno;
        $this->emailid = $this->item->email;
        $this->pincode = $this->item->pincode;
        $this->address1 = $this->item->address1;
        $this->address2 = $this->item->address2;
        $this->telephoneno = $this->item->telephone;
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
            'telephoneno'=>'required| numeric',
            'stdcode'=>'required| numeric',
            'address1'=>'required'
        
        ],
        [
            'name.required' => 'Name is required',
            'designation.required' => 'Designation is required',
            'city.required' => 'City is required',
            'state.required' => 'State is required',
            'pincode.required' => 'Pincode is required',
            'telephoneno.required' => 'Telephone No is required',
            'mobileno.required' =>'Mobile No is required',
            'emailid.required' =>'Email id is required',
            'address1.required' =>'Address is required',
            'designation.regex'=>'Only character and space is allowed',
            'emailid.regex'=>'Email id will be @nic.in or @gov.in',
            'stdcode.required'=>'Please enter STD code',

        
        ]);

    }
    public function update(){

        $this->validateData();
        $existingmodContact = DB::table('mod_contacts')->where('contactid',"=",$this->contactid)->get();
        $ifExists = $existingmodContact->count();
          $datatoChange= [
            'c_name' => $this->name.",".$this->designation,
            'city' => $this->city,
            'contactid' => $this->contactid,
            'mobileno'=>$this->mobileno,
            'email'=>$this->emailid,
            'pincode'=>$this->pincode,
            'address1'=>$this->address1,
            'address2'=>$this->address2,
            'telephone'=>$this->stdcode."-".$this->telephoneno,
            'city'=> $this->city,
            'domainid'=>$this->domain,
            'contact_type'=> $this->ctype,
            'req_type'=>2

           ];
        if($ifExists > 0){
            DB::table('mod_contacts')
            ->where('contactid', $this->contactid)
            ->update($datatoChange);
            session()->flash('message', 'Contact update request submitted. It will be approved and reflected soon');
            return redirect(route('single-domain',['domainid'=>$this->domain]));
        }else{
           DB::table('mod_contacts')
            ->insert($datatoChange);
        
            session()->flash('message', 'Contact update request submitted ');
            return redirect(route('my_domains'));
        }

        session()->flash('error', 'Data is not updated');
        return redirect(route('single-domain',['domainid' => $this->domain]));
    }


    public function render()
    {

        $states = DB::table('state_ut')->get();
        return view('livewire.mydomain.contact-update',[ 'states'=>$states,'domainid' => $this->domain]);
    }
}
