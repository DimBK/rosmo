<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $guarded = [];

    public function photos()
    {
        return $this->hasMany(GalleryPhoto::class)->orderBy('sort_order');
    }
}
