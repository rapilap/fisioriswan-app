<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventHighlight extends Model
{
    protected $fillable = [
        'title',
        'description',
        'image',
    ];

    /** Path yang dipakai di <img>, relatif terhadap folder public. */
    public function imagePath(): string
    {
        return 'storage/'.$this->image;
    }
}
