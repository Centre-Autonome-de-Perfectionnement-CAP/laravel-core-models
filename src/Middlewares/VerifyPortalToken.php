<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class VerifyPortalToken
{
    /**
     * Rôles autorisés à accéder à l'application.
     */
    protected array $allowedRoles = [
        'chef_division',
        'secretaire',
        'chef_cap',
    ];

    /**
     * Gardes d'authentification à vérifier.
     */
    protected array $guards = ['administration', 'professor', 'web'];

    public function handle(Request $request, Closure $next): Response
    {
        $portalUrl = env('PORTAL_URL', 'http://127.0.0.1:8000');

        Log::info('=== DEBUT VERIFICATION SESSION EXISTATNTE ===');

        foreach ($this->guards as $guard) {
            Log::info('Vérification garde', [
                'guard' => $guard,
                'auth_check' => Auth::guard($guard)->check(),
                'has_portal_token' => session()->has('portal_token'),
            ]);

            if (Auth::guard($guard)->check() && session()->has('portal_token')) {
                $user = Auth::guard($guard)->user();
                Log::info('Utilisateur authentifié', [
                    'guard' => $guard,
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'role' => $user->role->name ?? 'inconnu',
                ]);

                // Vérifier périodiquement le token (toutes les 5 minutes)
                if (!$this->shouldVerifyToken()) {
                    return $next($request);
                }
            }
        }

        Log::info('=== ECHEC VERIFICATION SESSION EXISTATNTE ===');

        // Vérification complète avec le portail
        return $this->verifyWithPortal($request, $portalUrl, $next);
    }

    protected function verifyWithPortal(Request $request, string $portalUrl, Closure $next): Response
    {
        Log::info('=== DEBUT VERIFICATION TOKEN ===');

        // Utiliser portal_token au lieu de portal_token
        $token = $request->input('access')
            ?? $request->bearerToken()
            ?? session('portal_token');

        if (empty($token)) {
            Log::warning('Token non trouvé');
            return redirect($portalUrl . '/login')->with('error', 'Veuillez vous connecter via le portail');
        }

        try {
            $response = Http::timeout(10)
                ->withHeaders(['Authorization' => 'Bearer ' . $token])
                ->post($portalUrl . '/api/verify-token');

            if (!$response->successful()) {
                Log::error('Échec de vérification du token', ['status' => $response->status()]);
                return redirect($portalUrl . '/login')->with('error', 'Session expirée');
            }

            $userData = $response->json();

            if (empty($userData['valid'])) {
                Log::error('Token invalide');
                return redirect($portalUrl . '/login')->with('error', 'Session invalide');
            }

            $role = $userData['user']['role'] ?? null;
            if (!in_array($role, $this->allowedRoles)) {
                Log::error('Rôle non autorisé', ['role' => $role]);
                return redirect($portalUrl . '/dashboard')->with('error', 'Accès non autorisé');
            }

            // Déterminer le garde et le modèle en fonction des données
            $guard = $this->determineGuard($userData['user']);
            $modelClass = $this->getModelClassForGuard($guard);

            // Récupérer l'utilisateur existant sans mise à jour
            $user = $modelClass::find($userData['user']['id']);

            if (!$user) {
                Log::error('Utilisateur non trouvé dans la base de données locale', [
                    'guard' => $guard,
                    'user_id' => $userData['user']['id'],
                ]);
                return redirect($portalUrl . '/login')->with('error', 'Utilisateur non trouvé');
            }

            // Authentifier l'utilisateur avec le garde approprié
            Auth::guard($guard)->login($user);
            Log::info('Utilisateur authentifié avec succès', [
                'guard' => $guard,
                'user_id' => $user->id,
                'email' => $user->email,
                'role' => $user->role->name ?? null,
            ]);

            // Stocker le token dans la session
            session([
                'portal_token' => $token,
                'last_token_verification' => now(),
                'auth_guard' => $guard, // Stocker le garde utilisé
            ]);

            Log::info('Session data after login', [
                'portal_token' => session('portal_token'),
                'last_token_verification' => session('last_token_verification'),
                'auth_guard' => session('auth_guard'),
                'auth_user_id' => Auth::guard($guard)->id(),
            ]);

            Log::info('=== TOKEN VERIFIE AVEC SUCCES ===');
            return $next($request);
        } catch (\Exception $e) {
            Log::error('Erreur de vérification du token', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return redirect($portalUrl . '/login')->with('error', 'Erreur de connexion au portail');
        }
    }

    protected function shouldVerifyToken(): bool
    {
        $lastVerification = session('last_token_verification');
        return !$lastVerification || now()->diffInMinutes($lastVerification) >= 5;
    }

    protected function determineGuard(array $userData): string
    {
        $role = $userData['role'] ?? null;

        if (in_array($role, ['chef_cap', 'comptable', 'secretaire', 'chef_division'])) {
            return 'administration';
        } elseif (in_array($role, ['professor', 'teacher'])) {
            return 'professor';
        }

        return 'web'; 
    }

    protected function getModelClassForGuard(string $guard): string
    {
        return match ($guard) {
            'administration' => \App\Models\Administration::class,
            'professor' => \App\Models\Professor::class,
            default => \App\Models\User::class,
        };
    }
}