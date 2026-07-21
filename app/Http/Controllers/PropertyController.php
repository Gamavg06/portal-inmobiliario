<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Services\WeatherService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PropertyController extends Controller
{
    /**
     * Display a listing of properties.
     */
    public function index(): View
    {
        // Fetch properties with their first image to optimize loading
        $properties = Property::with(['images', 'user'])->latest()->get();

        return view('properties.index', compact('properties'));
    }

    /**
     * Display the specified property detail.
     */
    public function show(Property $property): View
    {
        // Eager load images and owner details
        $property->load(['images', 'user']);

        return view('properties.show', compact('property'));
    }

    /**
     * API Endpoint to retrieve all properties with coordinates and images.
     */
    public function apiIndex(): JsonResponse
    {
        $properties = Property::with('images')->where('status', 'available')->get();

        return response()->json($properties);
    }

    /**
     * API Endpoint to retrieve real-time weather of a property's location.
     */
    public function apiWeather(Property $property, WeatherService $weatherService): JsonResponse
    {
        $weatherData = $weatherService->getWeather($property->latitude, $property->longitude);

        return response()->json($weatherData);
    }
}
