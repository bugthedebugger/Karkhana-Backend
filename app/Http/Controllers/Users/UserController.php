<?php

/**
 * 
 */
namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
	public function index(Request $request){
		$user  = $request->user();
		
		return response()->json([
			'name' => $user->name,
			'email' => $user->email
		]);
	}
}