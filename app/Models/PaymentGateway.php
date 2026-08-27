<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentGateway extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',
        'is_active',
    ];

    public function configs()
    {
        return $this->hasMany(PaymentGatewayConfig::class, 'gateway_id');
    }

    /**
     * Read a config value, optionally scoped to an environment
     * (e.g. 'sandbox' or 'live') so live keys can never be picked up
     * while running in sandbox mode, and vice versa.
     */
    public function getConfigValue($key, $environment = null, $default = null)
    {
        $configs = $this->configs->where('key_name', $key);

        if ($environment !== null) {
            $configs = $configs->where('environment', $environment);
        }

        $config = $configs->first();

        return $config ? $config->key_value : $default;
    }
}
