<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WeatherService
{
    /**
     * Fetch the current weather for the given coordinates.
     *
     * @param float $latitude
     * @param float $longitude
     * @return array
     */
    public function getWeather(float $latitude, float $longitude): array
    {
        $apiKey = config('services.openweather.key');

        if (!$apiKey) {
            Log::warning('OpenWeatherMap API Key is not set in configuration.');
            return [
                'error' => 'API Key no configurada',
                'temp' => null,
                'description' => 'Desconocido',
                'icon' => null,
                'humidity' => null,
            ];
        }

        try {
            $response = Http::get('https://api.openweathermap.org/data/2.5/weather', [
                'lat' => $latitude,
                'lon' => $longitude,
                'appid' => $apiKey,
                'units' => 'metric',
                'lang' => 'es',
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return [
                    'temp' => isset($data['main']['temp']) ? round($data['main']['temp'], 1) : null,
                    'description' => isset($data['weather'][0]['description']) ? ucfirst($data['weather'][0]['description']) : 'No disponible',
                    'icon' => $data['weather'][0]['icon'] ?? null,
                    'humidity' => $data['main']['humidity'] ?? null,
                ];
            }

            Log::error('OpenWeatherMap API responded with error status: ' . $response->status(), [
                'body' => $response->body()
            ]);

            return [
                'error' => 'Error al consultar clima en la API',
                'temp' => null,
                'description' => 'Servicio no disponible',
                'icon' => null,
                'humidity' => null,
            ];
        } catch (\Exception $e) {
            Log::error('Exception when querying OpenWeatherMap API: ' . $e->getMessage());
            return [
                'error' => 'Error de conexión',
                'temp' => null,
                'description' => 'Error de red',
                'icon' => null,
                'humidity' => null,
            ];
        }
    }
}
