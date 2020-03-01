<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Common\CommonResponses;
use Auth;
use App\User;
use Illuminate\Http\Request;

class ProfilesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function me() {
        $user = Auth::user();
        $roles = $user->roles;
        $userRoles = null;

        foreach($roles as $role) {
            $userRoles[] = [
                'id' => $role->id,
                'name' => $role->name,
                'description' => $role->description,
            ];
        }

        $userInfo = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'roles' => $userRoles,
        ];

        if ($user->id != 1) {
            $author = [
                'bio' => $user->info->bio,
                'facebook' => $user->info->facebook,
                'linkedin' => $user->info->linkedin,
                'twitter' => $user->info->twitter,
                'youtube' => $user->info->youtube,
                'instagram' => $user->info->instagram,
            ];
        } else {
            $author = null;
        }

        if ($user->id == 1) {
            $userInfo['avatar'] = 'https://upload.wikimedia.org/wikipedia/commons/7/7c/Profile_avatar_placeholder_large.png';
        } else {
            $userInfo['avatar'] = $user->info->avatar;
        }

        $userInfo['info'] = $author;

        return CommonResponses::success('success', true, $userInfo);
    }

    public function edit(Request $request) {
        $this->validate($request, [
            'password' => 'nullable|min:6',
            'bio' => 'required|min:6',
            'avatar' => 'required|mimes:jpeg,jpg,png,gif,svg',
            'linkedin' => 'nullable|string',
            'facebook' => 'nullable|string',
            'twitter' => 'nullable|string',
            'youtube' => 'nullable|string',
            'instagram' => 'nullable|string',
        ]);

        $filePath = 'images/users';
        $avatar = $request->avatar;
        $temp = Auth::user();
        $user = User::findOrFail($temp->id);

        \DB::beginTransaction();
        try {
            $saved = $avatar->store($filePath, 's3');

            $user->name = $request->name;
            if($request->password != null || !is_null($request->password) || $request->password !== 'null')
                $user->password = app('hash')->make($request->password);
            $user->save();
            $user->info()->update([
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

        return CommonResponses::success('Profile updated.');
    }

}
