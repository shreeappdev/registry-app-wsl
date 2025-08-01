<?php

use App\Livewire\Dashboard;
use App\Livewire\Mydomain\DomainList;
use Illuminate\Support\Facades\Route;
use App\Livewire\Mydomain\DomainStatus;
use App\Livewire\Mydomain\ContactUpdate;
use App\Livewire\Mydomain\DomainDetails;
use App\Livewire\Subdomain\SubdomainEdit;
use App\Livewire\Domaincancel\Domaincancel;
use App\Livewire\Subdomain\ManageSubdomain;
use App\Livewire\Subdomain\Subdomaindetails;
use App\Livewire\Mydomain\ContactUpdateStatus;
use App\Livewire\Subdomain\MultipleSubdomainRegistration;
use App\Livewire\Nameserver\EditNameserverForm;
use App\Livewire\Subdomain\SubdomainDeactivate;
use App\Livewire\Subdomain\ManageSubdomainLists;
use App\Livewire\Domaincancel\DomaincancelStatus;
use App\Livewire\Subdomain\SubdomainRegistration;
use App\Livewire\Domainregistration\Generateletter;
use App\Livewire\Domainregistration\Registrationform;
use App\Livewire\DomainTransfer\DomainTransferStatus;
use App\Livewire\Domaincancel\SubmitDomainCancelLetter;
use App\Livewire\DomainTransfer\GenerateTransferLetter;
use App\Livewire\DomainTransfer\DomainTransferLetterSubmit;
use App\Livewire\Domainregistration\SubmitRegistrationLetter;

Route::get('/', function () {
    return view('welcome');
});

   Route::prefix('user')->group(function () {

   Route::get('/dashboard', Dashboard::class)->name('dashboard');
   /** Domain Registration*/
   Route::get('/domainregistration',Registrationform::class)->name('domainregister');
   Route::get('/generateletter', Generateletter::class)->name('generatletter_domainreg');
   Route::get('/submitletter', SubmitRegistrationLetter::class)->name('submitletter_domainreg');

   Route::get('/generateletter-domaincancel',Domaincancel::class)->name('generateletter_domaincancel');
   Route::get('/submitletter-domaincancel', SubmitDomainCancelLetter::class)->name('submitletter_domaincancel');

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


