<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;
    
    protected $fillable = ['title', 'content', 'status', 'publish_date', 'image', 'show_toc', 'views'];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
