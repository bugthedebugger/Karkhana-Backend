<?php

namespace App\Http\Controllers\Roles;
use App\Http\Controllers\Controller;
use App\Model\Role;
use App\Common\CommonResponses;
use Auth;

class RolesController extends Controller
{
    /**
     * Base roles controller that provides list of roles
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function listRoles() {
        $roles = Role::notAdmin()->get();
        $data = null;

        foreach($roles as $role) {
            $data[] = [
                'id' => $role->id,
                'name' => $role->name,
                'description' => $role->description,
            ];
        }

        return CommonResponses::success('success', true, ['roles' => $data]);
    }

    public function getUserRoles() {
        $roles = Auth::User()->roles;
        foreach($roles as $role) {
            $data[] = [
                'id' => $role->id,
                'name' => $role->name,
                'description' => $role->description,
            ];
        }
        return CommonResponses::success('success', true, ['roles' => $data]);
    }
}
