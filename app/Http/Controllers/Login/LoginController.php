<?php

/**
 *
 */
namespace App\Http\Controllers\Login;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{

    public function login(Request $request)
    {

        $this->validate($request, [
            'password' => 'required|min:6',
            'email'    => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['error' => 'Credentials Not Matched', 'code' => 401], 401);
        }

        if (Hash::check($request->password, $user->password))
        {
            $passport = $user->createToken(config('envKeys.token.ApiToken'));
            // dd($passport->access_token);
            return [
                'email'       => $user->email,
                'token'       => $passport->accessToken,
                'expiry_date' => time($passport->toArray()['token']->expires_at),
            ];
        }
        else
        {
            return response()->json(['error' => 'Credentials Not Matched', 'code' => 401], 401);
        }

    }
}
