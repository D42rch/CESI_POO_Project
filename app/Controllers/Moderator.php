<?php

namespace App\Controllers;
use App\Models\RolesModel;
use App\Models\UsersModel;

class Moderator extends BaseController
{
    public function index()
    {
        $objUsersModel = new UsersModel();
        $user_id = session('user');
        $userInfos = $objUsersModel->find($user_id);
        $data = ['title'=>'Administrateur connecté : '];
        $data['arrUsers']   = $objUsersModel->findAll();
        $data['objRolesModel'] = new RolesModel(); // Instanciation du modèle
        $arrRole[1] = 'Utilisateur';
        $arrRole[2] = 'Modérateur';
        $data['arrRole'] = $arrRole;
        $data['userInfos'] = $userInfos;
        return view('moderator_view', $data);
    }

    public function edit($intId)
    {

        helper('form'); // Déclare l'utilisation du helper

        $objUsersModel = new UsersModel();
        $objRolesModel = new RolesModel();
        $username = session('user');
        $user = $objUsersModel->where('user_id', $intId)->first();
        $user_role = $objRolesModel->where('role_id', $user->role_id)->first();
        $allRole = $objRolesModel->findAll();
        $arrRole = array();

        $arrRole[1] = 'Utilisateur';
        $arrRole[2] = 'Modérateur';

        $data = ['title'=>'Administrateur connecté : ',
        'user'=>$user];

        // Il faut charger la librairie
        $validation = \Config\Services::validation(); 
        $validation->setRules([
                'username' => [
                    'label'  => 'pseudo',
                    'rules'  => 'required|is_unique[user.username]',
                    'errors' => [
                        'required' => 'Le {field} est obligatoire, veuillez indiquer le {field}',
                        'is_unique' => 'Le {field} est déjà utilisé',
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
            ]
        );


        // On donne des règles de validation une à une ou à travers d'un tableau (setRules)

        $arrErrors = array();
        $objUser = new \App\Entities\User_entity();

        if (count($this->request->getPost()) > 0){ // Le formulaire a été envoyé ?
            $objUser->fill($this->request->getPost());
            if ($validation->run($this->request->getPost())){ //on teste la validation du formulaire sur les données
                
                update($objUser);

            }else{
                $arrErrors = $validation->getErrors(); // on récupère les erreurs pour les afficher
    
                if(empty($arrErrors)){
                    $session = session();
                
                    $session->setFlashdata("message", "Un problème est survenu, veuillez réessayer ultérieurement !");
                    $session->markAsFlashdata("message", "Un problème est survenu, veuillez réessayer ultérieurement !");    
                }
            }
        }

        $data['arrErrors'] = $arrErrors;

        $data['form_open'] = form_open("Moderator/update");
        $data['form_id'] = form_hidden("user_id", $user->user_id, "id='user_id'");
        $data['label_username'] = form_label("Pseudo ", "username");
        $data['form_username'] = form_input("username", $user->username, "id='username'");
        $data['label_mail'] = form_label("Adresse mail ", "mail");
        $data['form_mail'] = form_input("mail", $user->mail, "id='mail'");
       
        $data['label_role'] = form_label("Rôle ", "role");
        $data['form_role'] = form_dropdown("role", $arrRole, "id='role'");
       
        $data['form_submit'] = form_submit("submit", "Modification");
        $data['form_close'] = form_close();

        return view('moderator_edit_view', $data);
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
        $data['form_open'] = form_open("Moderator/update/".$objUser->user_id);
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
}
