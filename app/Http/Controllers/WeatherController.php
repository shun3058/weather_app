<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;
use App\Models\WeatherData;
use App\Services\WeatherService;

class WeatherController extends Controller
{   
    private WeatherService $weatherService;

    public function __construct(WeatherService $weatherService)
    {
        $this->weatherService = $weatherService;
    }
    
    public function index()
    {
        return view('weather.index', [
            'apiConfigured' => $this->weatherService->isApiConfigured(s)
        ]);
    }

    public function search(Request $request)
    {
        $request->validate([
            'city' => 'required|string|min:2|max:50',
        ]);

        $cityName = $request->input('city');

        if (!$this->weatherService->isApiConfigured()) {
            return back()->withErrors(['city' => 'API設定が間違っています。']);
        }

        $weatherData = $this->weatherService->getCurrentWeather($cityName);

        if (!$weatherData) {
            return back()->withErrors(['city' => '都市がみつからないか、APIエラーが発生しました。']);
        }

        $city = City::firstOrCreate([
            'name' => $weatherData['city_name'],
            'country_code' => $weatherData['country_code'],
        ], [
            'latitude' => $weatherData['latitude'],
            'longtitude' => $weatherData['longtitude'],
        ]);

        $weather = WeatherData::create([
            'city_id' => $city->id,
            'provider' => $weatherData['provider'],
            'temperature' => $weatherData['temperature'],
            'humidity' => $weatherData['humidity'],
            'pressure' => $weatherData['pressure'],
            'description' => $weatherData['description'],
            'icon' => $weatherData['icon'],
            'wind_speed' => $weatherData['wind_speed'],
            'forecast_date' => $weatherData['forecast_date'],
        ]);

        return view('weather.result', [
            'city' => $city,
            'weatherData' => [$weather],
        ]);
    }
}


