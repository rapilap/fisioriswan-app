<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = [
        'fullname',
        'city',
        'image',
        'testimonial',
        'status',
    ];
}
