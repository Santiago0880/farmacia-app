<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Redirigir después del login según el rol.
     */
    protected function redirectTo()
    {
        $user = Auth::user();
        $rol = $user->rol ?? 'vendedor';
        
        if ($rol === 'administrador') {
            return '/dashboard';
        } elseif ($rol === 'encargado_inventario') {
            return '/dashboard';
        } else {
            return '/dashboard';
        }
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Determinar el campo de login (email o usuario).
     */
    public function username()
    {
        return 'email';
    }
}