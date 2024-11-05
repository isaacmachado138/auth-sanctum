<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

use Laravel\Sanctum\HasApiTokens;


class AuthController extends Controller
{

    /**
     * Registra um novo usuário
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @example
     * POST /api/register
     * {
     *     "name": "Test",
     *     "email": "test@example.com",
     *     "password": "password123"
     * }
     */
    public function register(Request $request)
    {
        Log::info('Register user', ['request' => $request]);
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['message' => 'User created successfully'], 201);
    }

    /**
     * Login e geração de token com Sanctum
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     * 
    * @example
    * POST /api/login
    * {
    *     "email": "test@example.com",
    *     "password": "password123"
    * }
    */
    public function login(Request $request)
    {
        Log::info('Login user', ['email' => $request->email]);

        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        // Usando Sanctum para criar um token de acesso
        $token = $user->createToken('auth_token', ['*'], Carbon::now()->addMinutes(config('sanctum.expiration')));

        Log::info('Token created', ['token' => $token]);

        $tokenAccess = $token->plainTextToken;

        return response()->json(['token' => $tokenAccess], 200);
    }

    /**
     * Logout e revogação do token
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        Log::info('Logout user', ['email' => $request->email]);

        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully'], 200);
    }

    /**
     * Verificação do token
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verify(Request $request)
    {
        // Retorna uma resposta vazia com status 200 se o token for válido
        return response()->json(['message' => 'Token is valid'], 200);
    }
}

