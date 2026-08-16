<?php

namespace AsefSondaj\AdaptationLayer\Models;

use Illuminate\Database\Eloquent\Model;

class AsefBlog extends Model
{
    protected $table = 'asef_bloglar';

    protected $fillable = [
        'slug', 'title', 'cat', 'lede', 'body', 'image', 'author',
        'read_time', 'published_at', 'is_active', 'sort',
    ];

    protected $casts = [
        'published_at' => 'date',
        'is_active'    => 'boolean',
        'sort'         => 'integer',
    ];
}
