<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'title', 'slug', 'body', 'meta_title', 'meta_description',
        'order', 'is_published', 'show_in_menu',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'show_in_menu' => 'boolean',
        ];
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeMenu($query)
    {
        return $query->where('show_in_menu', true)->orderBy('order');
    }
}
