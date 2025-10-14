<?php

namespace App\Livewire\Domaincancel;

use App\Models\Domain;
use Livewire\Component;
use Barryvdh\DomPDF\Facade\PDF;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Title;

class Domaincancel extends Component
{

    public $domainid;
    public $pageTitle;

   #[Title('Domain Cancel')]

    public function mount()
    {
        // Set the page title when the component is mounted
        $this->pageTitle = "Domain Cancellation";
    }
    
    public function generateCancelLetter(){

        $validated= $this->validate([
            'domainid' => 'required',
        ], 
        [
            'domainid.required' => 'Please choose domainname',
        ]);
        
        if( $validated){
    
            $domaindetails= Domain::where('domainid','=',$this->domainid)->first();
                $data = [
                    'title' => 'Cancellation Letter',
                    'date' => date('m/d/Y'),
                    'domain_name'=>$domaindetails->domainname,
                ];

                if(empty($domaindetails)){
                    return response()->json([
                        'success' => false,
                        'message' => 'There is some issue with domain details', 
                    ]);
                }

             // Load the view and pass the data to it
            $pdf = PDF::loadView('livewire.domaincancel.cancelletterformat',$data);
          

            // Return the generated PDF for download or inline display
            // return $pdf->download('document.pdf');
            // Or to display inline in the browser: return $pdf->stream();
             $filename = 'domaincancel_' . time() . '.pdf';

            // // Save the PDF in the public storage folder
             $path = storage_path('app/public/' . $filename);
   
             $pdf->save($path);

             $pdfurl = Storage::url($filename);
        
             

            // Return the URL to the generated PDF
            //return response()->json(['pdf_url' => asset("storage/{$filename}")]);

            $this->dispatch('cancelletterGenerated',
            type:'success',
            title:'Letter Generated',
            text:$domaindetails->domainname,
            date:date('Y-m-d'),
            html:"<p>Domain deactivation letter is generated successfuly <br> Download the <a href='{$pdfurl}' class='text-primary font-weight-bold'>letter</a></p>");

        }
    }

    public function render()
    {

        $domains=Domain::where('registrantid','yu7hdsy8394')->get();
        return view('livewire.domaincancel.domaincancel',['domains'=>$domains]);
    }
}
