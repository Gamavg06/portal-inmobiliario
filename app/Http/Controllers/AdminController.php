<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    /**
     * Display the Admin & Agent Dashboard.
     */
    public function dashboard()
    {
        $user = Auth::user();
        
        $properties = Property::with('images')->latest()->get();
        $leads = Lead::with(['property', 'user'])->latest()->get();
        $pendingAgents = \App\Models\User::where('role', 'agent')->where('is_approved', false)->latest()->get();

        $stats = [
            'total_properties' => $properties->count(),
            'total_leads' => $leads->count(),
            'pending_agents' => $pendingAgents->count(),
            'available_properties' => $properties->where('status', 'available')->count(),
        ];

        return view('admin.dashboard', compact('properties', 'leads', 'pendingAgents', 'stats', 'user'));
    }

    /**
     * Approve a pending agent.
     */
    public function approveAgent(\App\Models\User $user)
    {
        if ($user->role === 'agent') {
            $user->update(['is_approved' => true]);
            return redirect()->route('admin.dashboard')->with('success', "¡El agente {$user->name} ({$user->email}) ha sido aprobado exitosamente!");
        }
        return redirect()->route('admin.dashboard')->with('error', 'El usuario seleccionado no es un agente.');
    }

    /**
     * Show form to create a new property.
     */
    public function createProperty()
    {
        return view('admin.properties.create');
    }

    /**
     * Store a newly created property in storage.
     */
    public function storeProperty(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'address' => ['required', 'string', 'max:255'],
            'latitude' => ['required', 'numeric'],
            'longitude' => ['required', 'numeric'],
            'type' => ['required', 'in:house,apartment,commercial'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:4096'],
        ]);

        $user = Auth::user();

        // Create Property
        $property = $user->properties()->create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'address' => $validated['address'],
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
            'type' => $validated['type'],
            'status' => 'available',
        ]);

        // Handle Image Upload if provided
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('properties', 'public');
            $property->images()->create([
                'image_path' => $path,
            ]);
        } else {
            // Default sample image fallback
            $property->images()->create([
                'image_path' => 'properties/sample_chalet_1.jpg',
            ]);
        }

        return redirect()->route('admin.dashboard')->with('success', '¡Propiedad en Nopalucan publicada exitosamente!');
    }

    /**
     * Delete a property.
     */
    public function deleteProperty(Property $property)
    {
        $property->delete();
        return redirect()->route('admin.dashboard')->with('success', 'La propiedad ha sido eliminada.');
    }
}
