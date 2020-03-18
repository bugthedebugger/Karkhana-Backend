<?php

namespace App\Http\Controllers\DropALine;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\DropALineMail;
use Illuminate\Support\Facades\Mail;
use App\Common\CommonResponses;


class DropALineMailController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function send(Request $request) {
        $this->validate($request, [
            'name' => 'required|min:6',
            'email' => 'required|email',
            'topic' => 'required|min:6',
            'message' => 'required|min:6',
        ]);

        try {
            Mail::to(env('INFO_MAIL'))->send(new DropALineMail($request->name, $request->email, $request->topic, $request->message));
        } catch (\Exception $e) {
            return CommonResponses::exception($e);
        }

        return CommonResponses::success('Message delivered successfully!');
    }
}
