<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DomainRegistraionMultiStep extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table="domainregister_multistep";
    protected $fillable = [
        'userid',
        'form_id',
        'formdata',
        'formlevel',
    ];
}
