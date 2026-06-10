<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromoCardTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'promo_card_id',
        'language_code',
        'badge_text',
        'title',
        'button_text',
        'button_url',
        'image_url',
    ];

    /**
     * Get the promo card that owns the translation.
     */
    public function promoCard()
    {
        return $this->belongsTo(PromoCard::class);
    }
}
