<?php

namespace AsefSondaj\AdaptationLayer\Models;

use Illuminate\Database\Eloquent\Model;

class AsefFaq extends Model
{
    protected $table = 'asef_faqs';

    protected $fillable = ['q', 'a', 'is_active', 'sort'];

    protected $casts = [
        'is_active' => 'boolean',
        'sort'      => 'integer',
    ];
}
