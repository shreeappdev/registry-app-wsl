<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubdoamainCurrentIp extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'subdomain_current_ip';
    protected $fillable = ['domainid','subdomainid','multipleips','multiplecname'];
}
