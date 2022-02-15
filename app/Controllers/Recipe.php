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

        $data['search_mode'] = false;

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
                'rules' => 'required|valid_url|is_unique[recipe.source_URL]',
                'errors' => [
                    'required' => 'L\'{field} est obligatoire, veuillez indiquer un {field}',
                    'valid_url' => 'L\' {field} doit être valide',
                    'is_unique' => 'Cette recette est déjà ajoutée',
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



                $objRecipe->name = (isset($json_decode['title']) ? $json_decode['title'] : '');
                $objRecipe->image_URL = (isset($json_decode['image']) ? $json_decode['image'] : '');
                $objRecipe->servings = (isset($json_decode['servings']) ? $json_decode['servings'] : '');
                $objRecipe->readyInMinutes = (isset($json_decode['readyInMinutes']) ? $json_decode['readyInMinutes'] : '');
                $objRecipe->source_URL = (isset($json_decode['sourceUrl']) ? $json_decode['sourceUrl'] : '');
                $objRecipe->pricePerServing = (isset($json_decode['pricePerServing']) ? $json_decode['pricePerServing'] : '');
                $objRecipe->isCheap = (isset($json_decode['cheap']) ? $json_decode['cheap'] : '');
                
                $objRecipe->dairyFree = (isset($json_decode['dairyFree']) ? $json_decode['dairyFree'] : '');
                $objRecipe->glutenFree = (isset($json_decode['glutenFree']) ? $json_decode['glutenFree'] : '');
                $objRecipe->vegan = (isset($json_decode['vegan']) ? $json_decode['vegan'] : '');
                $objRecipe->vegatarian = (isset($json_decode['vegetarian']) ? $json_decode['vegetarian'] : '');
                $objRecipe->veryHealthy = (isset($json_decode['veryHealthy']) ? $json_decode['veryHealthy'] : '');
                $objRecipe->veryPopular = (isset($json_decode['veryPopular']) ? $json_decode['veryPopular'] : '');
                $objRecipe->summary = (isset($json_decode['summary']) ? $json_decode['summary'] : '');
                $objRecipe->instructions = (isset($json_decode['instructions']) ? $json_decode['instructions'] : '');

                //(!isset($json_decode['title'] ? $json_decode['title'] : '')



                // Traitement spécifique 
                $objRecipe->ketogenic = (!isset($json_decode['ketogenic'])) ?? false;
                $objRecipe->whole30 = (!isset($json_decode['whole30'])) ?? false;
                $objRecipe->dishType = implode(",", $json_decode['dishTypes']);

                // En fonction de la session user 
                //$objRecipe->owner = $json_decode['owner'];

                // En fonction de si l'user connecté est admin (state_id = 1) ou user (state_id = 3)
                //$objRecipe->state_id = 3;


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

    public function search()
    {

        helper('form');

        $data['name'] = "Rechercher une recette";

        $validation = \Config\Services::validation();
        $validation->setRules([
            'title' => [
                'label' => 'Nom de la recette',
                'rules' => 'required',
                'errors' => [
                    'required' => 'L\'{field} est obligatoire, veuillez indiquer un {field}',
                ]
            ]
        ]);

        $data['no_results'] = true;


        $arrErrors = array();
        if (count($this->request->getPost()) > 0) {

            if ($validation->run($this->request->getPost())) {

                $search_url = "https://api.spoonacular.com/recipes/complexSearch?number=10&apiKey=" . self::KEYAPI . "&titleMatch=" . $this->request->getPost('title');
                $search_json = file_get_contents($search_url);
                $data['arrRecipe'] = json_decode($search_json, true);



                $data['no_results'] = false;

            } else {

                $data['arrRecipe'] = 'unvalid';
            }
        } else {
            $data['arrRecipe'] = 'empty input';
        }


        $data['arrErrors'] = $arrErrors;


        $optionsType = [
            
            'main course',
            'side dish',
            'dessert',
            'appetizer',
            'salad',
            'bread',
            'breakfast',
            'soup',
            'beverage',
            'sauce',
            'marinade',
            'fingerfood',
            'snack',
            'drink',
            '',
        ];




        $data['form_open'] = form_open('recipe/search');

        // titleMatch 
        $data['label_title'] = form_label('Nom de la recette ', 'title');
        $data['form_title'] = form_input('title', $this->request->getPost('title') ?? "", "id='title' placeholder='Nom de la recette'");
        
        // type (https://spoonacular.com/food-api/docs#Meal-Types)
        $data['label_type'] = form_label('Type de recette ', 'type');
        $data['form_type'] = form_dropdown('type', $optionsType, 'main course', "id='type'");
        
        // maxReadyTime (number) 
        $data['label_time'] = form_label('Temps de cuisson max. (min)', 'time');
        $data['input_time'] = form_input('time', "30", null, 'number');


        $data['form_submit'] = form_submit("submit", "Rechercher");
        $data['form_close'] = form_open();

        $data['search_mode'] = true;

        echo view('recipe/recipe_list', $data);
    }
}
