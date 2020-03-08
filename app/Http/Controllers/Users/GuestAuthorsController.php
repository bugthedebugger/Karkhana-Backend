<?php

namespace App\Http\Controllers\Users;
use App\Http\Controllers\Controller;
use App\Model\GuestAuthor;

class GuestAuthorsController extends Controller
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

    /**
     * Function to return list of guests.
     */
    public function index() {
        $guest = GuestAuthor::orderBy('name', 'asc')->get();

        return $guest;
    }
}
