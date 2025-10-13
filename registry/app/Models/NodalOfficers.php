<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Ministry;      
use App\Models\Department;    
use App\Models\Organisation;  
use App\Models\Designation;  


class NodalOfficers extends Model
{
    use HasFactory;
    protected $table='nodal_nonnodal_officers';
    public $timestamps = false;
    protected $primaryKey='faid';

    protected $fillable = [
        'fa_nodal',
        'ministry',
        'department',
        'region',
        'state_utcode',
        'name',
        'org',
        'designation',
        'email',
        'by_regid',
        'is_active',
        'show_nodal',
        'org_id',
    ];

    public function minDetails()
    {
        return $this->belongsTo(Ministry::class, 'ministry', 'm_id')->withDefault([]);;
    }

    public function deptDetails()
    {
        return $this->belongsTo(Department::class, 'department', 'id')->withDefault([]);;
    }

    public function orgDetails()
    {
        return $this->belongsTo(Organisation::class, 'org_id', 'org_id')->withDefault([]);;
    }

    public function DesgDetails()
    {
        return $this->belongsTo(Designation::class, 'designation', 'id')->withDefault([]);;
    }



}
