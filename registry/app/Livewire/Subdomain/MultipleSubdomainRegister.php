<?php

namespace App\Livewire\Subdomain;

use App\Models\Domain;
use Livewire\Component;
use Livewire\Attributes\Title;
use Barryvdh\DomPDF\Facade\Pdf;


class MultipleSubdomainRegister extends Component
{

    public $subdomainsRow = [];
    public $domainid;
    
    #[Title('Manage Subdomain')]
    public function mount($id)
    {
      
        $this->addSubdomainRow(); // Add the first row by default
        //$this->addRowMappedIp(); //Add the first row by default
        $this->domainid = $id;
       
    }

    public function addSubdomainRow()
    {
        // Add a new row with empty fields and a default radio selection
        $this->subdomainsRow[] = [
            'subdomainname' => '', 
            'mapping' => '',
            'showIpDiv' => false,
            'showCnameDiv'=>false,
            'showRemovebtn'=>count($this->subdomainsRow) === 0 ? false:true,
            'ips' => ['']];
    }

    public function removeRow($index)
    {
        // Remove a row by its index
        unset($this->subdomainsRow[$index]);
        $this->subdomainsRow = array_values($this->subdomainsRow); 
    }

    public function addRowMappedIp($index)
    {
        //Add a new row with empty fields and a default radio selection
       // $this->mappedips[] = ['ip' => '','showRemovebtnMappedIp'=>true];

       $this->subdomainsRow[$index]['ips'][] = '';

    }

    public function removeRowMappedIp($index,$index_ip)
    {
        // Remove a row by its index
         unset($this->subdomainsRow[$index]['ips'][$index_ip]);
        // $this->subdomainsRow[$index]['mappedipcname'] = array_values($this->mappedips); // Reindex the array

        $this->subdomainsRow[$index]['ips'] = array_values($this->subdomainsRow[$index]['ips']);
    }

    public function onChangeMapping($index, $value)
    {

        $this->subdomainsRow[$index]['showIpDiv']=  $value === 'option1' ? true:false;
        $this->subdomainsRow[$index]['showCnameDiv']=  $value === 'option2' ? true:false;

    }

    public function generateLetter()
    {

        dd($this->subdomainsRow);

        foreach ($this->subdomainsRow as $row) {
         
         

        }


       $domaindetails= Domain::where('domainid','=',$this->domainid)->first();

       $data = [
        'title' => 'Registration Letters(Annex-1, Annex2)',
        'date' => date('m/d/Y'),
        'domain_name'=>$domaindetails->domainname,
      
       ];
    

        // Load the view and pass the data to it
        $pdf = PDF::loadView('userdashboard.subdomain.registrationletterformat', $data);
        $filename = 'example.pdf';
            
        // Save the PDF in the public storage folder
        $path = storage_path("app/public/{$filename}");
        $pdf->save($path);
       // session()->flash('message', 'Form submitted successfully! Download Pdf');

       $this->dispatch('multipleSubdomainLtrGenrete',type:'success',title:'Letter Generated',text:$domaindetails->domainname,date:date('Y-m-d'),html:"<p>Letter is generated</p>");
    }

 
    public function render()
    {

       
        return view('livewire.subdomain.multiple-subdomain-register');
    }
}
