<?php

namespace App\Http\Controllers\Admin\Registration;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegistrationMail;
use App\Common\CommonResponses;
use Illuminate\Http\Request;
use App\User;
use App\Model\Registration;
use Storage;
use App\Model\GuestAuthor;


class RegistrationController extends Controller
{
    public function sendRegistrationLink(Request $request) {
        $this->validate($request, [
            'email' => 'required|unique:users',
            'roles' => 'nullable|array',
            'roles.*' => 'integer',
            'redirect' => 'nullable',
        ]);

        \DB::beginTransaction();
        try {
            $user = User::create([
                'email' => $request->email,
            ]);
            $user->roles()->sync($request->roles);
            $token = $this->generateRegistrationToken();
            $user->registration()->create([
                'token' => $token,
            ]);
            Mail::to($user)->send(new RegistrationMail($token, $request->redirect));
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            return CommonResponses::exception($e);
        }
        
        return CommonResponses::success('Registration email sent successfully!');
    }

    public function resendRegistrationLink(Request $request) {
        $this->validate($request, [
            'email' => 'required',
            'redirect' => 'nullable',
        ]);

        $user = User::where('email', $request->email)->first();
        if($user) {
            $registrationToken = $user->registration->token;
            try {
                Mail::to($user)->send(new RegistrationMail($registrationToken, $request->redirect));
            } catch (\Exception $e) {
                return CommonResponses::exception($e);
            }
        } else {
            return CommonResponses::error('Invalid email.', 400);
        }
        return CommonResponses::success('Registration link resent successfully.');
    }

    private function generateRegistrationToken() {
        $token = Str::uuid();
        return $token; 
    }

    public function listUnregisteredUsers() {
        $unregistered = Registration::unregistered()->get();
        $data = null;
        
        foreach ($unregistered as $user) {
            $data[] = $user->user->email;
        }

        return CommonResponses::success('success', true, ['users' => $data]);
    }

    public function listRegisteredUsers() {
        $unregistered = Registration::registered()->get();
        $data = null;
        
        foreach ($unregistered as $user) {
            $data[] = [
                'id' => $user->user->id,
                'name' => $user->user->name,
                'email' => $user->user->email,
                'avatar' => Storage::disk('s3')->url($user->user->info->avatar),
            ];
        }

        return CommonResponses::success('success', true, ['users' => $data]);
    }

    public function cancelRegistration($email) {
        $user = User::where('email', $email)->first();

        if ($user) {
            if (!$user->registration->registered) {
                \DB::beginTransaction();
                try {
                    $user->delete();
                    \DB::commit();
                } catch (\Exception $e) {
                    \DB::rollback();
                    return CommonResponses::exception($e);
                }
                return CommonResponses::success('Email registration cancelled.');
            }
        } 

        return CommonResponses::error('Invalid Email', 400);
    }

    public function registerGuest(Request $request) {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|unique:guest_author',
            'bio' => 'required|min:6', 
            'avatar' => 'required|mimes:jpeg,jpg,png,gif,svg',
            'linkedin' => 'nullable',
            'facebook' => 'nullable',
            'twitter' => 'nullable',
            'youtube' => 'nullable',
            'instagram' => 'nullable',
        ]);

        $filePath = 'images/guest';
        $avatar = $request->avatar;

        \DB::beginTransaction();
        try {
            $saved = $avatar->store($filePath, 's3');
            $guest = GuestAuthor::create([
                'name' => $request->name,
                'email' => $request->email,
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

        $data = [
            'name' => $guest->name,
            'email' => $guest->email,
            'id' => $guest->id,
        ];

        return CommonResponses::success('Guest author registered successfully.', true, $data);
    }
}
