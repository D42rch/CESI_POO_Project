<?php

namespace App\Controllers;
use App\Models\UsersModel;

class Home extends BaseController
{
    public function index()
    {
        $user_id = session()->get('user');
        $usersModel = new UsersModel();
        $userInfos = $usersModel->find($user_id);
        $data = ['title'=>'Bienvenu(e) ',
        'userInfos' => $userInfos];
        return view('home_view', $data);
    }

    public function profile()
    {
        $user_id = session()->get('user');
        $usersModel = new UsersModel();
        $userInfos = $usersModel->find($user_d);
        $data = ['title'=>'Bienvenu(e) ',
        'userInfos' => $userInfos];
        return view('profil_view', $data);
    }
}
