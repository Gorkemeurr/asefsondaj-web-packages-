<?php

namespace AsefSondaj\AdaptationLayer\Models;

use Illuminate\Database\Eloquent\Model;

class AsefGlossaryTerm extends Model
{
    protected $table = 'asef_glossary_terms';

    protected $fillable = ['term', 'definition', 'is_active', 'sort'];

    protected $casts = [
        'is_active' => 'boolean',
        'sort'      => 'integer',
    ];
}
