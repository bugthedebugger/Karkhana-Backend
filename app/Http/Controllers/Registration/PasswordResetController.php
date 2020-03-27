<?php

namespace App\Http\Controllers\Registration;

use App\User;
use App\Http\Controllers\Controller;
use App\Common\CommonResponses;
use Illuminate\Http\Request;
use App\Mail\PasswordResetMail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Model\PasswordResetToken;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class PasswordResetController extends Controller
{
    public function sendReset(Request $request) {
        $this->validate($request, [
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();
        if ($user) {
            \DB::beginTransaction();
            try {
                $resetToken = $user->passwordResetToken()->validToken()->first();
                
                if($resetToken) {
                    
                } else {
                    $token =  Str::uuid();
                    $resetToken = $user->passwordResetToken()->create([
                        'token' => $token,
                    ]);
                }
                Mail::to($user)->send(new PasswordResetMail($resetToken->token, $request->redirect));
                \DB::commit();
            } catch (\Exception $e) {
                \DB::rollback();
                return CommonResponses::exception($e);
            }
            return CommonResponses::success('Reset token has been sent successfully');
        } else {
            return CommonResponses::error('Invalid email address!', 404);
        }
    }

    public function checkValid($token) {
        $token = PasswordResetToken::where('token', $token)->validToken()->first();
        if ($token) {
            $data = [
                'token' => $token->token,
                'email' => $token->user->email,
            ];
            return CommonResponses::success('Reset token valid!', true, $data);
        } else {
            return CommonResponses::error('Invalid reset token!');
        }
    }

    public function resetPassword(Request $request) {
        $this->validate($request, [
            'password' => 'required|min:6',
            'token' => 'required',
        ]);

        $token = PasswordResetToken::where('token', $request->token)->validToken()->first();
        
        if ($token) {
            $user = User::find($token->user->id);
            if ($user) {
                \DB::beginTransaction();
                try {
                    $password = Hash::make($request->password);
                    $user->password = $password;
                    $user->save();
                    $token->valid = false;
                    $token->save();
                    \DB::commit();
                } catch (\Exception $e) {
                    \DB::rollback();
                    return CommonResponses::exception($e);
                }
                return CommonResponses::success('Password reset successful!');
            } else {
                return CommonResponses::error('Invalid reset token!');
            }
        } else {
            return CommonResponses::error('Invalid reset token!');
        }
    }
}
