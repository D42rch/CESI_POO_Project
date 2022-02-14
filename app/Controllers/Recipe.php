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

        $search_url = "https://api.spoonacular.com/recipes/complexSearch?number=10&apiKey=" . self::KEYAPI;
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
                $extract_url = "https://api.spoonacular.com/recipes/extract?apiKey=" . self::KEYAPI . "&url=" . $this->request->getPost('source_url');
                $extract_json = file_get_contents($extract_url);
                $json_decode = json_decode($extract_json, true);

                $data['recipeJSON'] = $extract_json;
                $data['arrExtract'] = $json_decode;

                $data['recipe_json'] = $extract_json;





                //Traitement
                $objRecipeModel = new RecipesModel();
                $objRecipe = new \App\Entities\Recipe_entity();

                
                
                $objRecipe->name = $json_decode['title'];
                $objRecipe->image_URL = $json_decode['image'];
                $objRecipe->servings = $json_decode['servings'];
                $objRecipe->readyInMinutes = $json_decode['readyInMinutes'];
                $objRecipe->source_URL = $json_decode['sourceUrl'];
                $objRecipe->pricePerServing = $json_decode['pricePerServing'];
                $objRecipe->isCheap = $json_decode['cheap'];
                $objRecipe->dairyFree = $json_decode['dairyFree'];
                $objRecipe->glutenFree = $json_decode['glutenFree'];
                $objRecipe->vegan = $json_decode['vegan'];
                $objRecipe->vegatarian = $json_decode['vegetarian'];
                $objRecipe->veryHealthy = $json_decode['veryHealthy'];
                $objRecipe->veryPopular = $json_decode['veryPopular'];
                $objRecipe->summary = $json_decode['summary'];
                $objRecipe->instructions = $json_decode['instructions'];


                
                // Traitement spécifique 
                $objRecipe->ketogenic = (!ISSET($json_decode['ketogenic']))??false;
                $objRecipe->whole30 = (!ISSET($json_decode['whole30']))??false;
                $objRecipe->dishType = implode(",", $json_decode['dishTypes']);
                
                // En fonction de la session user 
                //$objRecipe->owner = $json_decode['owner'];

                // En fonction de si l'user connecté est admin (state_id = 1) ou user (state_id = 3)
                $objRecipe->state_id = 3;


                $objRecipeModel->save($objRecipe);


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

        x owner
        x name
        x image_URL
        x servings
        x readyInMinutes
        x source_URL
        x pricePerServing
        x isCheap
        x dairyFree
        x instructions
        x glutenFree
        x ketogenic
        x vegan
        x vegatarian
        x veryHealthy
        x veryPopular
        x whole30
        x dishType
        x summary
        
        recipe_id
        api_source_id
        state_id
        checksum
        api_source_URL
        nutrition_id
        likes
        healthScore
        cuisines
        diets
        lowFodmap
        pairedWines
        pairedWinesText	
        
        */
    }
}
