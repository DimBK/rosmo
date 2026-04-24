<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrganizationStructure extends Model
{
    protected $fillable = [
        'position_name',
        'official_name',
        'echelon',
        'image',
        'parent_id',
        'sort_order',
    ];

    public function parent()
    {
        return $this->belongsTo(OrganizationStructure::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(OrganizationStructure::class, 'parent_id')->orderBy('sort_order');
    }
}
