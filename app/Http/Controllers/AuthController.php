<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Laravel\Passport\Passport;

class AuthController extends Controller
{
    public function user(): Response
    {
        return new Response(Auth::user());
    }

    public function logout(): Response
    {
        $token = Auth::user()->token();
        $token->revoke();
        //$token->delete();
        return new Response(["success" => true]);
    }
}
