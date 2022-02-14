<?php

namespace App\Controllers;
use App\Models\RolesModel;
use App\Models\UsersModel;

class Moderator extends BaseController
{
    public function index()
    {
        $objUsersModel = new UsersModel();
        $username = session('user');
        $data = ['title'=>'Administrateur connecté : '];
        $data['arrUsers']   = $objUsersModel->findAll();
        $data['objRolesModel'] = new RolesModel(); // Instanciation du modèle
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
        'user'=>$user,
        'allRole'=>$allRole];
        $data['objRolesModel'] = new RolesModel(); // Instanciation du modèle



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

        if (count($this->request->getPost()) > 0){ // Le formulaire a été envoyé ?
            
            if ($validation->run($this->request->getPost())){ //on teste la validation du formulaire sur les données
                
                $objUser = new \App\Entities\User_entity(); // Instanciation de l'entité
                $objUser->fill($this->request->getPost());

                $objUsersModel->update($objUser,['user_id' => $intId]); // On modifie l'objet

                $session = session();

                $session->setFlashdata("message", "Vos modifications ont bien été mis à jour !");
                $session->markAsFlashdata("message", "Vos modifications ont bien été mis à jour !");

                return redirect()->to('/Moderator'); // redirection vers l'action par défaut du controller login

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

        $data['form_open'] = form_open("Moderator/edit");
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
        $username = session('user');
        $user = $objUsersModel->where('user_id', $intId)->first();

        $data = ['title'=>'Administrateur connecté : ',
        'user'=>$user];


                // $objUsersModel->delete($user); // On modifie l'objet

                $session = session();

                $session->setFlashdata("message", "Suppression effectuée !");
                $session->markAsFlashdata("message", "Suppression effectuée !");

                return redirect()->to('/Moderator'); // redirection vers l'action par défaut du controller login

        $data['arrErrors'] = $arrErrors;

        $data['form_open'] = form_open("Moderator");
        $data['form_id'] = form_hidden("user_id", $user->user_id, "id='user_id'");
        $data['label_username'] = form_label("Pseudo ", "username");
        $data['form_username'] = form_label( $user->username, "id='username'");
        $data['label_mail'] = form_label("Adresse mail ", "mail");
        $data['form_mail'] = form_label($user->mail, "id='mail'");
        $data['form_submit'] = form_submit("submit", "Suppression");
        $data['form_close'] = form_close();

        return view('moderator_delete_view', $data);
    }

    public function delete_user($intId)
    {
        $objUsersModel = new UsersModel();
        $objUsersModel->where('user_id', $intId);
        $objUsersModel->delete();
        return redirect()->to('/Moderator');
    }
}
