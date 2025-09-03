<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ErrorHandling
{
    protected $errorMessages = [
        400 => 'Mauvaise requête',
        401 => 'Non autorisé',
        403 => 'Accès interdit',
        404 => 'Page non trouvée'
    ];
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $response = $next($request);
            $status = $response->status();
            
            if ($status >= 400 && $status < 500) {
                return response()->view('errors.400', [
                    'errorCode' => $status,
                    'errorMessage' => $this->errorMessages[$status] ?? 'Erreur client'
                ], $status);
            }
            
            if ($status >= 500) {
                return response()->view('errors.500', [], 500);
            }
            
            return $response;
        } catch (\Exception $e) {
            return response()->view('errors.500', [], 500);
        }
    }
}
