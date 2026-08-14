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

    /**
     * Display the authenticated buyer's requests and reservation status.
     */
    public function myLeads()
    {
        $user = auth()->user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para consultar tus solicitudes.');
        }

        $leads = Lead::with(['property.images', 'property.user'])
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        $stats = [
            'total_requests' => $leads->count(),
            'approved_requests' => $leads->where('status', 'approved')->count(),
            'paid_requests' => $leads->where('status', 'paid')->count(),
        ];

        return view('client.dashboard', compact('leads', 'stats', 'user'));
    }

    /**
     * Show Digital Receipt / Ficha Oficial de Pre-Apartado for a Lead.
     */
    public function showReceipt(Lead $lead)
    {
        $lead->load(['property.user', 'user']);
        $paypalClientId = config('services.paypal.client_id');
        return view('leads.receipt', compact('lead', 'paypalClientId'));
    }

    /**
     * Process Successful PayPal Payment for Lead Reservation.
     */
    public function processPaypalPayment(Request $request, Lead $lead)
    {
        $validated = $request->validate([
            'paypal_transaction_id' => 'required|string',
        ]);

        try {
            $lead->update([
                'status' => 'paid',
                'paypal_transaction_id' => $validated['paypal_transaction_id'],
            ]);

            // Update Property Status to Reserved
            if ($lead->property) {
                $lead->property->update(['status' => 'reserved']);
            }

            return response()->json([
                'success' => true,
                'message' => '¡Pago de apartado registrado con éxito en PayPal! El inmueble ha sido reservado.',
            ]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error processing PayPal payment: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Ocurrió un error al procesar el pago: ' . $e->getMessage(),
            ], 500);
        }
    }
}
