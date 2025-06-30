<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nameserver_data extends Model
{
      use HasFactory;
     protected $table="nameservers_current_data";
     public $timestamps = false;
     protected $fillable=['current_data_sets','activation_status'];
}
