<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ServiceRequirement extends Model
{
    use HasFactory;

    protected $fillable = ['parent_id', 'title', 'slug', 'content', 'image', 'status', 'highlights', 'included', 'not_included'];

    public function parent()
    {
        return $this->belongsTo(ServiceRequirement::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(ServiceRequirement::class, 'parent_id');
    }
}
