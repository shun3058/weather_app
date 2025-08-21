<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WeatherData extends Model
{
    protected $fillable = [
        'city_id',
        'provider',
        'temperature',
        'humidity',
        'description',
        'icon',
        'pressure',
        'wind_speed',
        'forecast_date',
    ];

    protected $casts = [
        'temperature' => 'decimal:2',
        'pressure' => 'decimal:2',
        'wind_speed' => 'decimal:2',
        'forecast_date' => 'datetime',
    ];

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function getTemperatureCelsiusAttribute(): string
    {
        return number_format($this->temperature, 1) . '°C';
    }

}
