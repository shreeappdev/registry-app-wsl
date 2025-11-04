<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;
    protected $primaryKey ='contactid';
    public $timestamps = false;
    public $incrementing = false; 
    protected $keyType = 'string'; 
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

    public static function selectedDetails($id)
    {
        return self::select('c_name', 'designation')
            ->where('contactid', $id)
            ->first();
    }
}
