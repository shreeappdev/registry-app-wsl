<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
    use HasFactory;
    public $timestamps = false;
    public $PrimarKey='domainid';
    protected $fillable = ['domainid','domainname','lang','dname_decoded_punycode','registrantid','companyid','adminid','techid','registrationdate','updationdate','state_utcode','expirationdate','orgcategory','region','ministry','dept','org_id','has_idns','activation_stage','activation_status','mailsent','signedby','activation_date','remarks','nic_hod_hog_div_code'];


    public function registrationLetters()
    {
        return $this->hasMany(Authletter::class,'domainid','domainid'); //
    }


  


}
