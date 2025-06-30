<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StdCodes extends Model
{
     use HasFactory;
    protected $table = 'stdcodes';
    protected $primaryKey="id";
}
