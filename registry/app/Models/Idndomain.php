<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Idndomain extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table='idn_domains';
    protected $fillable=['id','master_domainid','domainid','domainname','lang','domainname_decoded','status','createdon','mailsent','activation_date'];

}
