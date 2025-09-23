<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;
    protected $primaryKey ='contactid';
    public $timestamps = false;
    protected $fillable = [
            'contactid',
            'c_name',
            'designation',
            'address1',
            'address2',
            'city',
            'state',
            'countryid',
            'pincode',
            'telephone_std_code',
            'country_dial_code',
            'telephone',
            'mobileno',
            'email'
        ];
}
