<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        if ($user = $this->authenticatedByPassword($request)) {
            $access = $this->getAccessToken($user);

            return $this->json(
                'Logged in successfully!', [
                    'user' => new UserResource($user),
                    'access' => $access,
                ]
            );
        }

        return $this->json('Invalid credential', [], Response::HTTP_UNAUTHORIZED);
    }

    public function logout()
    {
        $user = auth()->user();

        $user->tokens()->delete();

        return $this->json('Logged out successfully!');
    }

    private function authenticatedByPassword($request)
    {
        $user = User::findByEmail($request->email)->firstOrFail();
        if (! is_null($user) && Hash::check($request->password, $user->password)) {
            return $user;
        }

        return false;
    }

    private function getAccessToken(User $user): array
    {
        $token = $user->createToken('user token');

        return [
            'auth_type' => 'Bearer',
            'token' => $token->plainTextToken,
        ];
    }
}
