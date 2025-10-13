<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Ministry;      
use App\Models\Department;    
use App\Models\Organisation;
use App\Models\Orgcategory;      
use App\Models\StateUt;    
use App\Models\Contact;
use App\Models\Idndomain;

class Domain extends Model
{
    use HasFactory;
    public $timestamps = false;
    public $PrimarKey='domainid';
    protected $fillable = ['domainid','domainname','lang','dname_decoded_punycode','registrantid','companyid','adminid','techid','registrationdate','updationdate','state_utcode','expirationdate','orgcategory','region','ministry','dept','org_id','has_idns','activation_stage','activation_status','mailsent','signedby','activation_date','remarks','nic_hod_hog_div_code'];


    public function registrationLetters()
    {
        return $this->hasMany(Authletter::class,'domainid','domainid'); 
    }

    public function minDetails()
    {
        return $this->belongsTo(Ministry::class, 'ministry', 'm_id')->withDefault([]);;
    }

    public function orgcatDetails()
    {
        
        return $this->belongsTo(Orgcategory::class, 'orgcategory', 'orgcatid')->withDefault([]);
    }

    public function deptDetails()
    {
        return $this->belongsTo(Department::class, 'dept', 'id')->withDefault([]);;
    }

    public function stateDetails()
    {
        return $this->belongsTo(StateUt::class, 'state_utcode', 'state_utcode')->withDefault([]);
    }

    public function orgDetails()
    {
        return $this->belongsTo(Organisation::class, 'org_id', 'org_id')->withDefault([]);
    }

    public function orgContactDetails()
    {
        return $this->belongsTo(Contact::class, 'companyid', 'contactid')->withDefault([]);
    }

    public function adminContactDetails()
    {
        return $this->belongsTo(Contact::class, 'adminid', 'contactid')->withDefault([]);
    }
     public function idnDomainDetails()
    {
        return $this->belongsTo(Idndomain::class, 'domainid', 'master_domainid')->withDefault([]);
    }


}
