<?php

namespace AsefSondaj\AdaptationLayer\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AsefQuoteItem extends Model
{
    protected $table = 'asef_quote_items';

    protected $fillable = [
        'quote_id', 'product_sku', 'product_name', 'product_image',
        'quantity', 'unit_price', 'line_total', 'sort',
    ];

    protected $casts = [
        'quantity'   => 'integer',
        'unit_price' => 'decimal:2',
        'line_total' => 'decimal:2',
        'sort'       => 'integer',
    ];

    public function quote(): BelongsTo
    {
        return $this->belongsTo(AsefQuote::class, 'quote_id');
    }

    /**
     * Snapshot'lanmis image path'ini gercek URL'e cevir.
     * Bosca `asef/asef-hero-equipment.jpg` fallback'i kullan.
     */
    public function imageUrl(): string
    {
        if (! empty($this->product_image)) {
            return url('asef/' . $this->product_image);
        }
        return url('asef/asef-hero-equipment.jpg');
    }
}
