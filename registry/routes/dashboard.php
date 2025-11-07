<?php

use App\Livewire\Backend\Dashboard;
use App\Livewire\Backend\Mydomain\DomainList;
use Illuminate\Support\Facades\Route;
use App\Livewire\Backend\Mydomain\DomainStatus;
use App\Livewire\Backend\Mydomain\ContactUpdate;
use App\Livewire\Backend\Mydomain\DomainDetails;
use App\Livewire\Backend\Subdomain\SubdomainEdit;
use App\Livewire\Backend\Domaincancel\Domaincancel;
use App\Livewire\Backend\Subdomain\ManageSubdomain;
use App\Livewire\Backend\Subdomain\Subdomaindetails;
use App\Livewire\Backend\Mydomain\ContactUpdateStatus;
use App\Livewire\Backend\Subdomain\MultipleSubdomainRegistration;
use App\Livewire\Backend\Nameserver\EditNameserverForm;
use App\Livewire\Backend\Subdomain\SubdomainDeactivate;
use App\Livewire\Backend\Subdomain\ManageSubdomainLists;
use App\Livewire\Backend\Domaincancel\DomaincancelStatus;
use App\Livewire\Backend\Subdomain\SubdomainRegistration;
use App\Livewire\Backend\Domainregistration\Generateletter;
use App\Livewire\Backend\Domainregistration\ViewGeneratedLetter;
use App\Livewire\Backend\Domainregistration\Registrationform;
use App\Livewire\Backend\DomainTransfer\DomainTransferStatus;
use App\Livewire\Backend\Domaincancel\SubmitDomainCancelLetter;
use App\Livewire\Backend\DomainTransfer\GenerateTransferLetter;
use App\Livewire\Backend\DomainTransfer\DomainTransferLetterSubmit;
use App\Livewire\Backend\Domainregistration\SubmitRegistrationLetter;
use App\Livewire\Backend\Subdomain\Registration\SingleSubdomainReg;
use App\Livewire\Backend\Subdomain\SubmitLetter\SingleSubdomainSubmitLetter;

   Route::prefix('user')->group(function () {

   Route::get('/dashboard', Dashboard::class)->name('dashboard');
   /** Domain Registration*/
   Route::get('/domainregistration',Registrationform::class)->name('domainregister');
   Route::get('/generateletter', Generateletter::class)->name('generateletter_domainreg');
   Route::get('/view-generatedletter', ViewGeneratedLetter::class)->name('view_generateletter_domainreg');
   Route::get('/submitletter', SubmitRegistrationLetter::class)->name('submitletter_domainreg');
   /** Domain cancel*/
   Route::get('/generateletter-domaincancel',Domaincancel::class)->name('generateletter_domaincancel');
   Route::get('/submitletter-domaincancel', SubmitDomainCancelLetter::class)->name('submitletter_domaincancel');

   /** Single SubDomain Registration*/
   Route::get('/single-subdomain-registration', SingleSubdomainReg::class)->name('single_subdomain_registration');
   Route::get('/single-subdomain-submitletter', SingleSubdomainSubmitLetter::class)->name('single_subdomain_submitletter');



   Route::get('/subdomain-registration', SubdomainRegistration::class)->name('subdomain_registration');
   // Route::get('/multiple-subdomain-registration/{id}', MultipleSubdomainRegister::class)->name('multiplesubdomain_register');

   Route::get('/multiplesubdomain-registration', MultipleSubdomainRegistration::class)->name('bulksubdomain_register');

   Route::get('/subdomain-management',ManageSubdomain::class)->name('manage_subdomain');
   Route::get('/subdomain-lists',ManageSubdomainLists::class)->name('subdomain-lists');
   Route::get('/subdomain-details/{subdomain}',Subdomaindetails::class)->name('subdomain-details');
   Route::get('/subdomain-edit/{subdomain}',SubdomainEdit::class)->name('subdomain-edit');
   Route::get('/subdomain-deactivate/{subdomain}',SubdomainDeactivate::class)->name('subdomain-deactivate');

   Route::get('/domaintransfer-generateletter', GenerateTransferLetter::class)->name('domaintrnsfer_generateletter');
   Route::get('/domaintransfer-submitletter', DomainTransferLetterSubmit::class)->name('domaintransfer_submitletter');
   Route::get('/domaintransfer-status', DomainTransferStatus::class)->name('domaintransfer_status');



   Route::get('/domain-status',  DomainStatus::class)->name('domain_status');
   Route::get('/mydomains', DomainList::class)->name('my_domains');
   Route::get('/mydomains/{domainid}', DomainDetails::class)->name('single-domain');
   Route::get('/editcontact/{id}/{domain}/{ctype}', ContactUpdate::class)->name('editcontactform');
   Route::get('/update-nameserver/{domain}', EditNameserverForm::class)->name('edit_nameserver');

   
   Route::get('/domain-cancel-status',  DomaincancelStatus::class)->name('domain_cancel_status');

   Route::get('/generate-undertaking', function () {
      return view('userdashboard.nameserver-undertaking.generateletter');
   })->name('nameserver_undertaking_generate');

   Route::get('/submit-undertaking', function () {
      return view('userdashboard.nameserver-undertaking.submitletter');
   })->name('nameserver_undertaking_submit');

   Route::get('/nameserver_undertaking', function () {
      return view('userdashboard.nameserver-undertaking.undertakinglist');
   })->name('nameserver_undertaking');
   
   Route::get('/contactupdate-status', ContactUpdateStatus::class)->name('contactupdate_status');
});


