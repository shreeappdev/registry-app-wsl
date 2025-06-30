<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cancelletters extends Model
{
    use HasFactory;
    protected $primaryKey="c_id";
    protected $fillable = ['domainid','filesize','filetype,','file_name','al_remarks','mail_sent','mail_sent_date','domainname','registrantid','adminid','companyid','techid','state_utcode','status_time_of_delete','orgcategory','region','ministry','department','signedby','lang','request_type','nameservers'];
    public $timestamps = false;
}
