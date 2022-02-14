<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\RecipesModel;
use App\Libraries\Hash;



class Recipe extends Controller
{

    public const KEYAPI = 'a986bb3f492143e3bbb67f5c4080a2cb';

    public function index()
    {
        $objRecipeModel = new RecipesModel();
        // Variables pour la vue
        $data['name'] = "Liste des recettes";

        
        //$data['arrProduct'] = $objRecipeModel->findAll();

        $search_url = "https://api.spoonacular.com/recipes/complexSearch?number=10&apiKey=".self::KEYAPI;
        $search_json = file_get_contents($search_url);
        $data['arrRecipe'] = json_decode($search_json, true);

        echo view('recipe/recipe_list', $data);
    }

    public function add()
    {

        helper('form');
        $data['title'] = "Ajouter une recette";


        $validation = \Config\Services::validation();
        $validation->setRules([
            'source_url' => [
                'label' => 'URL',
                'rules' => 'required|valid_url',
                'errors' => [
                    'required' => 'L\'{field} est obligatoire, veuillez indiquer un {field}',
                    'valid_url' => 'L\' {field} doit être valide',
                ]
            ]
        ]);

        $arrErrors = array();
        if (count($this->request->getPost()) > 0) {
            if ($validation->run($this->request->getPost())) {

                // Call API 
                $extract_url="https://api.spoonacular.com/recipes/extract?apiKey=".self::KEYAPI."&url=".$this->request->getPost('source_url');
                $extract_json= file_get_contents($extract_url);
                $data['recipeJSON'] = $extract_json;
                //$data['arrExtract'] = json_decode($extract_json, true);


            } else {
                $arrErrors = $validation->getErrors(); // on récupère les erreurs pour les afficher

                if (empty($arrErrors)) {
                    $session = session();

                    $session->setFlashdata("message", "Un problème est survenu, veuillez réessayer ultérieurement !");
                    $session->markAsFlashdata("message", "Un problème est survenu, veuillez réessayer ultérieurement !");
                }
            }
        }

        $data['arrErrors'] = $arrErrors;

        // Formulaire        
        $data['form_open'] = form_open("recipe/add");
        $data['label_url'] = form_label("URL", "source_url");
        $data['input_url'] = form_input("source_url", $this->request->getPost('source_url') ?? "", "id='source_url'");
        $data['form_submit'] = form_submit("submit", "Ajout d'une recette");
        $data['form_close'] = form_close();

        echo view('recipe/recipe_add', $data);


        /*
        
        recipe_id
        api_source_id
        owner
        state_id

        checksum

        x name
        x image_URL

        servings
        readyInMinutes

        source_URL
        api_source_URL
        nutrition_id
        likes
        healthScore
        pricePerServing
        isCheap
        cuisines
        dairyFree
        instructions
        diets
        glutenFree
        ketogenic
        lowFodmap
        vegan
        vegatarian
        veryHealthy
        veryPopular
        whole30
        dishType
        summary
        pairedWines
        pairedWinesText	
        
        */
    }
}
