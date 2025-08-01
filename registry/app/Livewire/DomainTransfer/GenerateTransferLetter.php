<?php

namespace App\Livewire\DomainTransfer;

use App\Models\Contact;
use Livewire\Component;
use Livewire\Attributes\Title;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Helpers\Customdbresults;
use Illuminate\Support\Facades\Storage;


class GenerateTransferLetter extends Component
{


    public $n=1;
    public $field=1;
    public $no_of_domain=1;
    public $language;
    public $extension;
    public $domainname_transfer=[];
    
    #[Title('Domain Transfer')]
    public function validateData(){
        $this->validate(
             [
               "language"=>"required",
               "no_of_domain"=>"required",

             ],
             [
                'language.required' => 'Please choose the domain language',
                'no_of_domain.required' => 'Select the no of domain',
             ]);
            
    }

    public function generatetransferLetter(){
        $this->validateData();
        $this->domainname_transfer= array_map(function($value){
            return $value.$this->extension;
        },$this->domainname_transfer);
    

        $loginContactDetails = Contact::where('contactid', '=','yu756sy8309')->first() ? : null;
        
        if (empty($loginContactDetails)) {
            session()->flash('failed','There is some error with Login Account details');
            return;
        }

        $submitteddomains=rtrim(",",implode(",",$this->domainname_transfer));

        $data = [
            'title' => 'Domain Transfer Letter',
            'date' => date('m/d/Y'),
            'domain' => $submitteddomains,
            'organisationPersonName' => $loginContactDetails->c_name ?? 'N/A',
            'email' => $loginContactDetails->email ??   'N/A',
          
        ];

        $pdf = pdf::loadView('livewire.Letterformat.domaintransfer', $data);

            $filename = 'domain_transferletter'.date('dd-mm-yy-H-i-s').'.pdf';
            // Save the PDF in the public storage folder
            $path = storage_path("app/public/{$filename}");
            $pdf->save($path);

            $pdfurl = Storage::url($filename);
            $this->dispatch('transferletterGenerated',type:'success',title:'Letter Generated',date:date('Y-m-d'),html:"<p>Domain Transfer Letter Generated.User should dign the letter by the higher authority of the login person.<br>Download the <a href='{$pdfurl}' class='text-primary font-weight-bold'>letter</a></p>");

    }

    public function render()
    {

        $getLaguges = Customdbresults::getLanguges();
        $getextention = Customdbresults::getLangugeDetails($this->language??'en');
        $this->extension=$getextention->extension;
        return view('livewire.domain-transfer.generate-transfer-letter',['languges'=>$getLaguges]);
    }
}
