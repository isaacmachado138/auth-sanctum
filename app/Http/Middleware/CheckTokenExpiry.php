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
        Log::info('Check token expiry', ['request' => $request]);
        /*
        $user = $request->user(); 

        if ($user && $user->currentAccessToken()) {
            $lastUsed = $user->currentAccessToken()->last_used_at;
            $expirationPeriod = 30; // Define o tempo de expiração em minutos

            // Verifica se o token está inativo por mais tempo que o período definido
            if (Carbon::parse($lastUsed)->diffInMinutes(now()) > $expirationPeriod) {
                // Invalida o token se estiver inativo por muito tempo
                $user->currentAccessToken()->delete();
                return response()->json(['message' => 'Token expired'], 401);
            }
        }*/

        return $next($request);
    }
}
