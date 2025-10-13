<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organisation extends Model
{
    use HasFactory;
    protected $table = 'organisations';
    protected $primaryKey='org_id'; 

    protected $fillable = [
        'org_name',
        'm_id',
        'dept_id',
        'orgcat_id',
        'state_utcode',
    ];

}
