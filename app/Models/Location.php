<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{

//echo 'ol';
    protected $table = 'location';
    protected $fillable = [
        'location_name', 'created_at', 'updated_at',
    ];
}
