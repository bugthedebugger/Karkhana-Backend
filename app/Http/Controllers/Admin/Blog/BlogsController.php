<?php

namespace App\Http\Controllers\Admin\Blog;
use App\Http\Controllers\Controller;

class BlogsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Function to display the list of BLOGs
     * @return json
     */
    public function index($language) {
        dd($language);
        return ('Controlled!');
    }

    /**
     * Function to store new BLOG
     * @return json
     */
    public function store() {

    }

    /**
     * Funciton to autosave the BLOG
     */
    public function autosave() {

    }

    public function edit() {

    }

    public function update() {

    }
}
