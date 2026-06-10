<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    use HasFactory;

    // The table associated with the model (optional if it's singular version of the model name)
    protected $table = 'site_settings';

    // The attributes that are mass assignable
    protected $fillable = [
        'site_name',
        'tagline',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'logo',
        'favicon',
        'contact_email',
        'contact_phone',
        'contact_phone_2',
        'address',
        'footer_text',
        'default_currency',
        'default_language',
    ];

    // The attributes that should be cast to native types
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Optional: You may want to include any relationships (e.g., translations, if necessary)
}
