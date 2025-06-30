<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;
    protected $primaryKey ='contactid';
    public $timestamps = false;
    protected $fillable = ['contactid','c_name','address1','address2','city','state','countryid','pincode','telephone','mobileno','email','created_at'];

}
