<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $user = User::where("email", $request->email)->first();
        // || !Hash::check($request->password, $user->password

        if (!$user) {
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
