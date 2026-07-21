<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Lead;
use App\Models\User;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    /**
     * Store a newly created lead in storage.
     */
    public function store(Request $request, Property $property)
    {
        // Validate request
        $request->validate([
            'message' => 'required|string|min:5|max:1000',
        ]);

        // Get authenticated user ID, or fallback to the first buyer user for testing purposes
        $userId = auth()->id() ?? User::where('role', 'buyer')->first()?->id;

        if (!$userId) {
            return $request->wantsJson()
                ? response()->json(['error' => 'Debe existir al menos un usuario de tipo comprador en la base de datos.'], 422)
                : back()->withErrors(['user_id' => 'Debe existir al menos un usuario de tipo comprador en la base de datos.']);
        }

        // Create Lead
        Lead::create([
            'property_id' => $property->id,
            'user_id' => $userId,
            'message' => $request->message,
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => '¡Mensaje de contacto enviado con éxito! El agente se comunicará contigo pronto.'
            ], 201);
        }

        return back()->with('success', '¡Mensaje de contacto enviado con éxito! El agente se comunicará contigo pronto.');
    }
}
