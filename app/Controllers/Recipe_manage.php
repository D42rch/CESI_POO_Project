<?php

namespace App\Controllers;
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\RecipesModel;

class Recipe_manage extends BaseController
{
    public function index()
    {
        $objUsersModel = new UsersModel();
        $objRecipesModel = new RecipesModel();
        $arrRecipes = $objRecipesModel->findAll();
        $user_id = session('user');
        $userInfos = $objUsersModel->find($user_id);

        $data = ['title'=>'Administrateur connecté : '];
        $data['arrUsers']   = $objUsersModel->findAll();
        $data['objRolesModel'] = new RolesModel(); // Instanciation du modèle
        $data['arrRole'] = $arrRole;
        $data['userInfos'] = $userInfos;
        $data['arrRecipes'] = $arrRecipes;

        return view('manage_recipe_view', $data);
    }
}