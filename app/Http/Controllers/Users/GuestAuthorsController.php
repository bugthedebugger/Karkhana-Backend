<?php

namespace App\Http\Controllers\Users;
use App\Http\Controllers\Controller;
use App\Model\GuestAuthor;
use App\Common\CommonResponses;

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
        $guests = GuestAuthor::orderBy('name', 'asc')->get();
        $data = null;

        foreach ($guests as $guest) {
            $data[] = $guest->info();
        }

        return CommonResponses::success('success', true, $data);
    }
}
