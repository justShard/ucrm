<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;


class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if(!$user || !Hash::check($request->password, $user->password )){
            throw ValidationException::withMessages([
                'email' => ['Credentials incorrect']
            ]);
        }

        return response()->json([
            'user' => $user,
            'token' => $user->createToken('lavarel_api_token')->plainTextToken,
        ]);
    }
}