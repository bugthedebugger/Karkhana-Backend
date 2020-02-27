<?php

namespace App\Http\Controllers\Admin\Registration;
use App\Http\Controllers;
use Illuminate\Support\Str;
use Carbon\Carbon;


class RegistrationController extends Controllers
{
    public function sendRegistrationLink() {
        // TODO: register mailing drivers and configurations
    }

    public function resendRegistrationLink() {
        // TODO: resend registration link
    }

    protected function generateRegistrationToken() {
        $token = Str::uuid();
        return $token; 
    }

    public function listUnregisteredUsers() {
        // TODO: list unregistered users
    }

    public function listRegisteredUsers() {
        // TODO: list registered users
    }

    public function cancelRegistration() {
        // TODO: cancel registration of user
    }
}
