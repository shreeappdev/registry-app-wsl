<?php

namespace App\Models;

use App\Models\Subdomain;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubdomainLetter extends Model
{
    use HasFactory;

    protected $table="domain_fld_letters";
    protected $primaryKey="t_id";
    protected $fillable = ['subdomainid','domainname','subdomainname'];
     public $timestamps = false;


     public function subdomain()
     {
         return $this->belongsTo(Subdomain::class,'id','subdomainid'); // authid is local primary key and domainid is foreign key
         //need to define these keys of authletters table
     }
}
