<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Carbon\Carbon;

use Illuminate\Support\Facades\Log;

class CheckTokenExpiry
{
    public function handle(Request $request, Closure $next)
    {
        Log::info('Check token expiry');

        $user = $request->user(); 
        
        if ($user && $user->currentAccessToken()) {
            $expirationPeriod = config('sanctum.expiration'); // Pega o valor do arquivo de configuração

            $lastUsedToken      = $user->currentAccessToken()->last_used_at;
            $expirationToken    = $user->currentAccessToken()->expires_at;
            

            Log::info("Verify token, last used at $lastUsedToken, expires at $expirationToken");

            // Verifica se o token ainda é válido
            if (Carbon::parse($expirationToken)->isPast()) {
                Log::info('Token expired');
                $user->currentAccessToken()->delete();
                return response()->json(['message' => 'Token expired'], 401);
            } else {
                // Renova a expiração do token para o tempo definido na configuração
                Log::info('Token is valid');
                $user->currentAccessToken()->forceFill(['expires_at' => now()->addMinutes($expirationPeriod)])->save();
            }
        } else {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
