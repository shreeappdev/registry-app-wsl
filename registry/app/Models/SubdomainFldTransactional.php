<?php

namespace App\Models;

use App\Models\SubdomainLetter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubdomainFldTransactional extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table ='domain_fld_transactional';
    protected $fillable = ['subdomainid','subdomainname','domainid','multipleips','multiplecname'];

    // public function subdomainLetters()
    // {
    //     return $this->hasMany(SubdomainLetter::class,'subdomainid','subdomainid'); //
    // }
    
}