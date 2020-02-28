<?php

namespace App\Http\Controllers\Registration;
use App\Http\Controllers\Controller;
use App\User;
use App\Model\Registration;
use App\Common\CommonResponses;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function registrationCheck($token) {
        $registration = $this->checkToken($token);

        if ($registration) {
            return CommonResponses::success(
                'User registration possible.', 
                true, 
                ['token' => $token]
            );
        } 

        return CommonResponses::error('Invalid registration token.', 400);
    }

    public function registerUser(Request $request) {
        $this->validate($request, [
            'token' => 'required',
            'name' => 'required|min:6',
            'password' => 'required|min:6',
            'bio' => 'required|min:6',
            'avatar' => 'required|mimes:jpeg,jpg,png,gif,svg',
            'linkedin' => 'nullable|string',
            'facebook' => 'nullable|string',
            'twitter' => 'nullable|string',
            'youtube' => 'nullable|string',
            'instagram' => 'nullable|string',
        ]);

        if ($this->checkToken($request->token)) {
            $user = Registration::where('token', $request->token)->first()->user;
            $filePath = 'images/users';
            $avatar = $request->avatar;

            \DB::beginTransaction();
            try {
                $saved = $avatar->store($filePath, 's3');

                $user->name = $request->name;
                $user->password = app('hash')->make($request->password);
                $user->save();
                $user->registration->registered = true;
                $user->registration->save();
                $user->info()->create([
                    'bio' => $request->bio, 
                    'avatar' => $saved,
                    'linkedin' => $request->linkedin,
                    'facebook' => $request->facebook,
                    'twitter' => $request->twitter,
                    'youtube' => $request->youtube,
                    'instagram' => $request->instagram,
                ]);
                \DB::commit();
            } catch (\Exception $e) {
                \DB::rollback();
                return CommonResponses::exception($e);
            }

            $passport = $user->createToken(config('envKeys.token.ApiToken'));

            $data = [
                'email'       => $user->email,
                'token'       => $passport->accessToken,
                'expiry_date' => time($passport->toArray()['token']->expires_at),
            ];

            return CommonResponses::success('User registered successfully!', true, $data);
        }

        return CommonResponses::error('Invalid registration token.', 400);
    }

    protected function checkToken($token) {
        return Registration::where([
            ['token', '=', $token],
            ['registered', '=', false]
        ])->count() == 1? true: false;
    }
}
