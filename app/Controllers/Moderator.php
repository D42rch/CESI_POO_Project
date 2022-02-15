<?php

namespace App\Controllers;
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\RecipesModel;
use App\Models\StatesModel;

class Moderator extends BaseController
{
    public function index()
    {
        $objUsersModel = new UsersModel();
        $user_id = session('user');
        $userInfos = $objUsersModel->find($user_id);
        $data = ['title'=>'Administrateur connecté : '];
        $data['arrUsers'] = $objUsersModel->findAll();
        $data['objRolesModel'] = new RolesModel(); // Instanciation du modèle
        $arrRole[1] = 'Utilisateur';
        $arrRole[2] = 'Modérateur';
        $data['arrRole'] = $arrRole;
        $data['userInfos'] = $userInfos;
        return view('moderator_view', $data);
    }

    public function delete($intId)
    {

        helper('form'); // Déclare l'utilisation du helper

        $objUsersModel = new UsersModel();
        $user_id = session('user');
        $objUser = $objUsersModel->find($intId);
        $userInfos = $objUsersModel->find($user_id);

        $arrRole = array();

        $arrRole[1] = 'Utilisateur';
        $arrRole[2] = 'Modérateur';

        $data = ['title'=>'Administrateur connecté : ',
        'user'=>$objUser,
        'intId'=>$intId,
        'userInfos'=>$userInfos];

        $session = session();

        $session->setFlashdata("message", "Suppression effectuée !");
        $session->markAsFlashdata("message", "Suppression effectuée !");

        $arrErrors = array();
        $data['arrErrors'] = $arrErrors;

        $data['form_open'] = form_open("Moderator/delete");
        $data['form_id'] = form_hidden("user_id", $objUser->user_id, "id='user_id'");
        $data['label_username'] = form_label("Pseudo ", "username");
        $data['form_username'] = form_label( $objUser->username, "id='username'");
        $data['label_mail'] = form_label("Adresse mail ", "mail");
        $data['form_mail'] = form_label($objUser->mail, "id='mail'");
        $data['label_role'] = form_label("Rôle ", "role");
        $data['form_role'] = form_label($arrRole[$objUser->role], "id='role'");
        $data['form_submit'] = form_submit("submit", "Suppression");
        $data['form_close'] = form_close();

        return view('moderator_delete_view', $data);
    }

    public function update($intId)
    {
        // Déclare l'utilisation du helper
        helper('form');
        
        // Instanciation du modèle
        $objUsersModel = new UsersModel();
        // Instanciation de l'entité
        $objUser = new \App\Entities\User_entity();
        $user_id = session('user');
        $userInfos = $objUsersModel->find($user_id);
        $arrUsers = $objUsersModel->findAll();
        
        $arrRole = array();

        $arrRole[1] = 'Utilisateur';
        $arrRole[2] = 'Modérateur';
   
        $data['title'] = "Administrateur connecté : ";
        $data['arrUsers'] = $arrUsers;
        $data['arrRole'] = $arrRole;
        $data['userInfos'] = $userInfos;
      
        $objUser = $objUsersModel->find($intId);
        
        // Il faut charger la librairie
        $validation = \Config\Services::validation();
        
        // On donne des règles de validation
        $validation->setRules([
            'username' => [
                'label'  => 'pseudo',
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Le {field} est obligatoire, veuillez indiquer le {field}',
                ],
            ],
            'mail' => [
                'label'  => 'adresse mail',
                'rules'  => 'required|valid_email',
                'errors' => [
                    'required' => 'L\' {field} est obligatoire, veuillez indiquer l\' {field}',
                    'valid_email' => 'L\' {field} doit être valide',
                ],
            ],
        ]);
        $arrErrors = array();
        // Le formulaire a été envoyé ?
        if (count($this->request->getPost()) > 0){
            $objUser->fill($this->request->getPost());
            //on teste la validation du formulaire sur les données
            if ($validation->run($this->request->getPost())){
                // On sauvegarde l'objet
                $objUsersModel->save($objUser);
                // redirection vers l'action par défaut du controller Product
                return redirect()->to('Moderator');
            }else{
                // on récupère les erreurs pour les afficher
                $arrErrors = $validation->getErrors();
            }
        }
     
        $data['arrErrors'] = $arrErrors;
        $data['form_open'] = form_open("Moderator/update/".$intId);
        $data['form_id'] = form_hidden("user_id", $objUser->user_id??'', "id='user_id'");
        $data['label_username'] = form_label("Pseudo", "username");
        $data['form_username'] = form_input("username", $objUser->username??'', "id='username'");
        $data['label_mail'] = form_label("Adresse mail", "mail");
        $data['form_mail'] = form_input("mail", $objUser->mail??'', "id='mail'");
        $data['label_role'] = form_label("Rôle ", "role");
        $data['form_role'] = form_dropdown("role", $arrRole, "id='role'");
        $data['form_submit'] = form_submit("submit", "Modifier");
        $data['form_close'] = form_close();
       
           echo view('moderator_edit_view', $data);
    }

    public function delete_user($intId)
    {
        $objUsersModel = new UsersModel();
        $objUsersModel->where('user_id', $intId);
        $objUsersModel->delete();

        
        return redirect()->to('Moderator');
    }

    public function recipe_list()
    {
        $objUsersModel = new UsersModel();
        $objRecipesModel = new RecipesModel();
        $objStatesModel = new StatesModel();
        $arrRecipes = $objRecipesModel->findAll();

        $arrState = array();
        $arrState[1] = 'Publish';
        $arrState[2] = 'Archived';
        $arrState[3] = 'Waiting to publish';
        $arrState[4] = 'Waiting to update';

        $user_id = session('user');
        $userInfos = $objUsersModel->find($user_id);

        $data = ['title'=>'Administration des recettes : '];
        $data['userInfos'] = $userInfos;
        $data['arrRecipes'] = $arrRecipes;
        $data['arrState'] = $arrState;

        return view('manage_recipe_view', $data);
    }

    public function updateRecipe($intId)
    {
        // Déclare l'utilisation du helper
        helper('form');
        
        // Instanciation du modèle
        $objRecipesModel = new RecipesModel();
        $objUsersModel = new UsersModel();
        $objStatesModel = new StatesModel();
        // Instanciation de l'entité
        $objRecipe = new \App\Entities\Recipe_entity();
        $objState = new \App\Entities\State_entity();
        $user_id = session('user');
        $userInfos = $objUsersModel->find($user_id);
        
        $arrState = array();
        $arrState[1] = 'Publish';
        $arrState[2] = 'Archived';
        $arrState[3] = 'Waiting to publish';
        $arrState[4] = 'Waiting to update';
   
        $data['title'] = "Administrateur connecté : ";
        $data['userInfos'] = $userInfos;
     

          // Il faut charger la librairie
          $validation = \Config\Services::validation();
        
          // On donne des règles de validation
          $validation->setRules([
              'state' => [
                  'label'  => 'État',
                  'rules'  => 'required',
                  'errors' => [
                      'required' => 'L\' {field} est obligatoire, veuillez indiquer le {field}',
                    ],
                ],
            ]);
            $objRecipe = $objRecipesModel->find($intId);
            $objState = $objStatesModel->find($objRecipe->state_id);
        // Le formulaire a été envoyé ?
        if (count($this->request->getPost()) > 0){
            $objState->state = $this->request->getPost('state');
            $objState = $objStatesModel->where('state', $objState->state);
            $objRecipe->state_id = $objState->state_id;
            //on teste la validation du formulaire sur les données
            if ($validation->run($this->request->getPost())){
                // On sauvegarde l'objet
                $objRecipesModel->insert($objRecipe);
                // redirection vers l'action par défaut du controller Product
                return redirect()->to('Moderator/recipe_list');
            }else{
                // on récupère les erreurs pour les afficher
                $arrErrors = $validation->getErrors();
            }
        }
    
        $data['form_open'] = form_open("Moderator/updateRecipe/".$intId);
        $data['form_id'] = form_hidden("state_id", $objState->user_id??'', "id='state_id'");
        $data['label_state'] = form_label("État ", "lstate");
        $data['form_state'] = form_dropdown("state", $arrState, "id='state'");
        $data['form_submit'] = form_submit("submit", "Modifier");
        $data['form_close'] = form_close();
       
           echo view('manage_recipe_update_view', $data);
    }
}
