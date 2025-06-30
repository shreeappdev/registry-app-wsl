<?php

namespace App\Models;

use App\Models\SubdomainLetter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subdomain extends Model
{
    use HasFactory;
    protected $table ='domain_fld';

    public function subdomainLetters()
    {
        return $this->hasMany(SubdomainLetter::class,'subdomainid','subdomainid'); //
    }
    
}
