<?php 

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

//Rota para registro
Route::post('/register', [AuthController::class, 'register']);

//Rota para login
Route::post('/login', [AuthController::class, 'login'])->name('login');

//Essas rotas podem retornar 405 caso o token esteja expirado ou já tenha sido excluído
Route::middleware(['auth:sanctum'])->group(function () { 
    //Rota para logout
    Route::post('/logout', [AuthController::class, 'logout']);

    //Rota para verificar se token é valido (pode tambem ser usada a middleware auth:sanctum, porém ela irá retornar 405 se for expirado)
    Route::get('/verify', [AuthController::class, 'verify'])->middleware(\App\Http\Middleware\CheckTokenExpiry::class);
});