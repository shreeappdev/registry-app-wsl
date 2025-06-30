<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IdnLanguage extends Model
{
    use HasFactory;
    protected $table="idn_language";

    protected $primaryKey="authid";
}
