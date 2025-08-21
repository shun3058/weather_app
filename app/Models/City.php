<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class City extends Model
{
    protected $fillable = ['name', 'country_code', 'latitude', 'longitude'];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    public function weatherData(): HasMany
    {
        return $this->hasMany(WeatherData::class);
    }

    public function getFullNameAttribute(): string
    {
        return $this->name . ', ' . $this->country_code;
    }
}
