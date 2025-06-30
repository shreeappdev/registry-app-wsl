<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NodalOfficers extends Model
{
    use HasFactory;
    protected $table='nodal_nonnodal_officers';
    public $timestamps = false;
    protected $primaryKey='faid';
}
