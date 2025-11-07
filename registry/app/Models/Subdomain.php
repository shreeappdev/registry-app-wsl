<?php

namespace App\Models;

use App\Models\SubdomainLetter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subdomain extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table ='domain_fld';
    protected $fillable = [ 
                            'subdomainid',
                            'domainid',
                            'domainname',
                            'subdomainname',
                            'registrantid',
                            'registrationdate',
                            'lastupd_date',
                            'multipleips',
                            'multiplecname',
                            'activation_status'
                        ];

    public function subdomainLetters()
    {
        return $this->hasMany(SubdomainLetter::class,'subdomainid','subdomainid'); //
    }
    
}
