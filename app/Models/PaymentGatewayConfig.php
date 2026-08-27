<?php

namespace App\Models;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class PaymentGatewayConfig extends Model
{
    protected $fillable = ['gateway_id', 'key_name', 'is_encrypted', 'environment', 'key_value'];

    public function gateway()
    {
        return $this->belongsTo(PaymentGateway::class, 'gateway_id');
    }

    public function getKeyValueAttribute($value)
    {
        if ($this->is_encrypted && $value) {
            try {
                return Crypt::decryptString($value);
            } catch (DecryptException) {
                // Rows written before encryption round-tripped (or seeded
                // plaintext) are returned as stored.
                return $value;
            }
        }

        return $value;
    }

    public function setKeyValueAttribute($value)
    {
        $this->attributes['key_value'] = $this->is_encrypted && $value
            ? Crypt::encryptString($value)
            : $value;
    }
}
