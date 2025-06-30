<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Authletter extends Model
{
    use HasFactory;
     protected $primaryKey="authid";
     protected $fillable = ['domainid','lettertype','file_name','as_remark'];
     public $timestamps = false;

    public function domain()
    {
        return $this->belongsTo(Domain::class,'domainid','authid'); // authid is local orimary key and domainid is foreign key
        //need to define these keys of authletters table
    }

    public function asReason()
    {
        return $this->hasOne(AsReason::class, 'as_reason_no', 'as_reason'); //as_reason is take from authletters table and as_Reason_no is foreign key of as_reason table 
    }
}
