<?php

namespace App\Controllers;
use App\Models\UsersModel;

class Home extends BaseController
{
    public function index()
    {
        $data = ['title'=>'Bienvenu(e) '];
        return view('home_view', $data);
    }
}
