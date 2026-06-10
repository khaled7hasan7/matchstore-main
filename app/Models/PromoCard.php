<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class PromoCard extends Model
{
    use HasFactory;

    protected $fillable = [
        'size',
        'order',
        'status',
    ];

    /**
     * Get the translations for the promo card.
     */
    public function translations()
    {
        return $this->hasMany(PromoCardTranslation::class);
    }

    public function translation()
    {
        return $this->hasOne(PromoCardTranslation::class)->where('language_code', App::getLocale());
    }
}
