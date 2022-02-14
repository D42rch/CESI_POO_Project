<?php namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\RecipesModel;
use App\Libraries\Hash;

class Recipe extends Controller
{
    public function index() {
        $objRecipeModel = new RecipesModel();
        // Variables pour la vue
        $data['name'] = "Liste des recettes";
        $data['arrProduct'] = $objRecipeModel->findAll();

        echo view('recipe/recipe_list',$data);
    
    }
}