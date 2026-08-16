<?php

namespace AsefSondaj\AdaptationLayer\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AsefAnaKategori extends Model
{
    protected $table = 'asef_ana_kategoriler';

    protected $fillable = [
        'code', 'name', 'slug', 'description', 'meta_title', 'image', 'sort',
    ];

    public function altKategoriler(): HasMany
    {
        return $this->hasMany(AsefAltKategori::class, 'parent_code', 'code')->orderBy('sort');
    }

    public function products(): HasMany
    {
        return $this->hasMany(AsefProduct::class, 'ana_code', 'code');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
