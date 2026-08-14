<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Show Login Form.
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user());
        }
        return view('auth.login');
    }

    /**
     * Handle Login Request.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember = $request->has('remember');

        // 1. Standard authentication attempt
        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();

            // Check if agent is approved
            if ($user->role === 'agent' && !$user->is_approved) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()->withErrors([
                    'email' => 'Tu cuenta de Agente Inmobiliario aún no ha sido aprobada por el Administrador General.',
                ])->onlyInput('email');
            }

            $request->session()->regenerate();
            return $this->redirectBasedOnRole($user, '¡Bienvenido de nuevo, ' . $user->name . '!');
        }

        // 2. Flexible auto-registration if email doesn't exist yet
        $existingUser = User::where('email', $request->email)->first();
        if (!$existingUser) {
            $role = str_contains(strtolower($request->email), 'admin') ? 'admin' : 'buyer';
            $name = ucfirst(explode('@', $request->email)[0]);

            $newUser = User::create([
                'name' => $name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $role,
                'is_approved' => true,
            ]);

            Auth::login($newUser, $remember);
            $request->session()->regenerate();

            return $this->redirectBasedOnRole($newUser, '¡Cuenta creada e inicio de sesión exitoso como ' . ucfirst($newUser->name) . '!');
        }

        // 3. Password mismatch for existing user
        return back()->withErrors([
            'password' => 'La contraseña ingresada no es correcta para este correo.',
        ])->onlyInput('email');
    }

    /**
     * Show Register Form.
     */
    public function showRegisterForm()
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user());
        }
        return view('auth.register');
    }

    /**
     * Handle User Registration.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'role' => ['required', 'in:buyer,agent'],
        ]);

        $isApproved = ($request->role === 'buyer');

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'is_approved' => $isApproved,
        ]);

        if ($request->role === 'agent') {
            return redirect()->route('login')->with('success', '¡Registro de Agente recibido! Tu solicitud de cuenta ha sido enviada al Administrador General para su activación.');
        }

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('properties.index')->with('success', '¡Registro exitoso! Bienvenido a SGNIA Real Estate.');
    }

    /**
     * Handle Logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('properties.index')->with('success', 'Has cerrado sesión correctamente.');
    }

    /**
     * Helper to redirect according to user role.
     */
    private function redirectBasedOnRole(User $user, ?string $message = null)
    {
        $response = in_array($user->role, ['admin', 'agent'])
            ? redirect()->route('admin.dashboard')
            : redirect()->route('properties.index');

        if ($message) {
            $response->with('success', $message);
        }

        return $response;
    }
}
