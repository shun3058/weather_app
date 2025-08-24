<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;

class WeatherController extends Controller
{   
    public function index()
    {
        return view('weather.index');
    }

    public function search(Request $request)
    {
        $request->validate([
            'city' => 'required|string|min:2|max:50',
        ]);

        $cityName = $request->input('city');

        return view('weather.result', [
            'cityName' => $cityName,
            'message' => 'API連携は今後実装します'
        ]);
    }
}


