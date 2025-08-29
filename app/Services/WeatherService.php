<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;

class WeatherService
{
    private Client $httpClient;
    private string $apikey;
    private string $baseUrl;

    public function __construct()
    {
        $this->httpClient = new Client(['timeout' => 10]);
        $this->apikey = config('servises.openweather.api_key');
        $this->baseUrl = config('services.openweather.base_url');
    }

    public function getCurrentWeather(string $cityname): ?array
    {
        $coordinates = $this->getCoodinatesByCity($cityname);
        if(!$coordinates) {
            return null;
        }

        return $this->getWeatherByCoordinates($coordinates['lat'], $coordinates['lon']);
    }

    private function getCoordinatesByCity(string $cityname): ?array
    {
        try {
            $response = $this->httpClient->get('http://api.openweathermap.org/geo/1.0/direct', [
                'query' => [
                    'q' => $cityname,
                    'limit' => 1,
                    'appid' => $this->apiKey,
                ]
            ]);

            $data = json_decode($response->getBody(), true);

            if (empty($data)) {
                return null;
            }

            return [
                'lat' => $data[0]['lat'],
                'lon' => $data[0]['lon'],
                'name' => $data[0]['name'],
                'country' => $data[0]['country']
            ];
        } catch (RequestException $e) {
            Log::error('Geocoding API Error: ' . $e->getMessage());
            return null;
        }
    }

    private function getWeatherByCoordinates(float $lat, float $lon): ?array
    {
        try {
            $response = $this->httpClient->get($this->baseUrl . '/weather', [
                'query' => [
                    'lat' => $lat,
                    'lon' => $lon,
                    'appid' => $this->apiKey,
                    'units' => 'matric',
                    'lang' => 'ja'
                ]
            ]);

            $data = json_decode($response->getBody(),true);

            return $this->formatWeatherData($data);
        } catch (RequestException $e) {
            Log::error('OpenWeatherMap API Error: ' . $e->getMessage());
            return null;
        }
    }

    private function formatWeatherData(array $rawData): array
    {
        return [
            'provider' => 'openweather',
            'city_name' => $rawData['name'],
            'country_code' => $rawData['sys']['country'],
            'latitude' => $rawData['coord']['lat'],
            'longitude' => $rawData['coord']['lon'],
            'temperature' => $rawData['main']['temp'],
            'humidity' => $rawData['main']['humidity'],
            'pressure' => $rawData['main']['pressure'],
            'description' => $rawData['weather'][0]['description'],
            'icon' => $rawData['weather'][0]['icon'],
            'wind_speed' => $rawData['wind']['speed'] ?? 0,
            'forecast_date' => now(),
        ];
    }

    public function isApiConfigured(): bool
    {
        return !empty($this->apiKey) && !empty($this->baseUrl);
    }
}

