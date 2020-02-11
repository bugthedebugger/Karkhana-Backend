<?php

namespace App\Http\Controllers\Register;

use App\Http\Controllers\Controller;
use App\Mail\RegisterMail;
use App\Mail\VerifiedMail;
use App\Model\Verify;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use \Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\User;

class RegisterController extends Controller
{
    public function index(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
        ]);

        $date = Carbon::now()->addDay();

        $token = Str::random(16);

        if (Verify::where('token', $token)->first())
        {
            $token = Str::random(16);
        }

        try {
            DB::beginTransaction();

            Verify::create([
                'email'     => $request->email,
                'token'     => $token,
                'expire_at' => $date,
            ]);

            DB::commit();

        }
        catch (Exception $e)
        {
            DB::rollback();

            return response()->json([
                'message' => 'Something went wrong',
            ], 500);
        }

        Mail::to($request->email)->send(new RegisterMail($token));

        return response()->json([
            'message' => 'Successfully Recieved',
        ], 200);

    }

    public function verify(Request $request, $token)
    {

        $verify = Verify::where('token', $token)->where('verified', false)->first();

        if (!$verify) {
        	return response()->json([
        		'message' => 'Verificatin Link expired'
        	], 400);
        }

        if ($verify->isExpired())
        {
            return 'expired';
        }
        else
        {
            $email    = $verify->email;
            $password = Str::random(10);

            try {

                DB::beginTransaction();

                $user = new User();
                $user->name = $email;
                $user->email = $email;
                $user->setPasswordAttribute(Hash::make($password));
                $user->save();
                // User::create([
                //     'email'    => $email,
                //     'name'     => $email,
                //     'password' => Hash::make($password),
                // ]);

                $verify->verified = true;

                $verify->verified_at = Carbon::now();

                $verify->save();

                DB::commit();

            }
            catch (Exception $e)
            {
                DB::rollback();

                return response()->json([
                    'message' => 'Something went wrong',
                ], 500);

            }

            Mail::to($email)->send(new VerifiedMail($email, $password));

        }

        return response()->json([
            'message' => 'Successfully Created',
        ], 200);
    }
}
