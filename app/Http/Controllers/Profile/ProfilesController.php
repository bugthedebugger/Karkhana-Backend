<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Common\CommonResponses;
use Auth;

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

        if ($user->id == 1) {
            $userInfo['avatar'] = 'https://upload.wikimedia.org/wikipedia/commons/7/7c/Profile_avatar_placeholder_large.png';
        } else {
            $userInfo['avatar'] = $user->info->avatar;
        }

        return CommonResponses::success('success', true, $userInfo);
    }

}
