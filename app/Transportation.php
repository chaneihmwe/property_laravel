<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transportation extends Model
{
    //
    protected $fillable = [
        'transportation_type', 'transportation_image'
    ];
}
