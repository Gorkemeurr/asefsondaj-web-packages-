<?php

namespace AsefSondaj\AdaptationLayer\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AsefAltKategori extends Model
{
    protected $table = 'asef_alt_kategoriler';

    protected $fillable = [
        'code', 'name', 'slug', 'parent_code', 'description', 'meta_title', 'image', 'sort',
    ];

    public function ana(): BelongsTo
    {
        return $this->belongsTo(AsefAnaKategori::class, 'parent_code', 'code');
    }

    public function products(): HasMany
    {
        return $this->hasMany(AsefProduct::class, 'alt_code', 'code')->orderBy('sort');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
