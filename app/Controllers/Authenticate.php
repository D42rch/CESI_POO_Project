<?php namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\UsersModel;
use App\Libraries\Hash;


class Authenticate extends Controller
{
    
    public function _construct()
    {
        helper(['url', 'form']);
    }

    public function index()
    {
        helper('form'); // Déclare l'utilisation du helper
        $data['title'] = "Connexion";

        $validation = \Config\Services::validation(); 
        $validation->setRules([
                'username' => [
                    'label'  => 'Pseudo',
                    'rules'  => 'required|is_not_unique[user.username]',
                    'errors' => [
                        'required' => 'Le {field} est obligatoire',
                        'is_not_unique' => 'Le {field} n\'éxiste pas',
                    ],
                ],
                'hash_password' => [
                    'label'  => 'Mot de passe',
                    'rules'  => 'required',
                    'errors' => [
                        'required' => 'Mauvais {field} est obligatoire, veuillez indiquer le {field}',
                    ],
                ],
            ]
        );


            $arrErrors = array();

            if (count($this->request->getPost()) > 0){ // Le formulaire a été envoyé ?
                if ($validation->run($this->request->getPost())){ //on teste la validation du formulaire sur les données

                    $session = \Config\Services::session();

                    $objUsersModel = new UsersModel(); // Instanciation du modèle
                    $objUser = new \App\Entities\User_entity(); // Instanciation de l'entité
                    $pseudo = $this->request->getPost('username');
                    $password = $this->request->getPost('hash_password');
 
                    $db_user = $objUsersModel->where('username', $pseudo)->first();
                    $db_mdpuser = $db_user->hash_password;
                    $check_password = Hash::check($password, $db_mdpuser);
                    
                    if($check_password){
                        // $info_user = [
                        //     'user_id' => $db_user->user_id,
                        //     'username' => $db_user->username,
                        //     'mail' => $db_user->mail,
                        //     'role' => $db_user->role,
                        // ];
                        // $session->set('user', $info_user);
                        return redirect()->to('/Home');
                        
                    }
    
                    log_message('error', $pseudo);
                    log_message('error', $db_mdpuser);
            }else{
                $arrErrors = $validation->getErrors(); // on récupère les erreurs pour les afficher
            }

        }
        $data['arrErrors'] = $arrErrors;

        $data['form_open'] = form_open("Authenticate/index");
        $data['label_username'] = form_label("Pseudo", "username");
        $data['form_username'] = form_input("username", $this->request->getPost('username')??"", "id='username'");
        $data['label_hash_password'] = form_label("Mot de passe", "hash_password");
        $data['form_hash_password'] = form_input("hash_password", $this->request->getPost('hash_password')??"", "id='hash_password' type='password'");
        $data['form_submit'] = form_submit("submit", "Connexion");
        $data['form_close'] = form_close();
        
        echo view('auth/signin_view', $data);
    }
    public function register()
    {
        helper('form'); // Déclare l'utilisation du helper
 
        $data['title'] = "Inscritpion";

        // Il faut charger la librairie
        $validation = \Config\Services::validation(); 
  
        $validation->setRules([
                'username' => [
                    'label'  => 'Pseudo',
                    'rules'  => 'required|is_unique[user.username]',
                    'errors' => [
                        'required' => 'Le {field} est obligatoire, veuillez indiquer le {field}',
                        'is_unique' => 'Le {field} est déjà utilisé',
                    ],
                ],
                'hash_password' => [
                    'label'  => 'Mots de passes',
                    'rules'  => 'required|matches[user_cmdp]',
                    'errors' => [
                        'required' => 'Le {field} est obligatoire, veuillez indiquer le {field}',
                        'matches' => 'Les {field} sont différents',
                    ],
                ],
                'mail' => [
                    'label'  => 'Adresse mail',
                    'rules'  => 'required|valid_email',
                    'errors' => [
                        'required' => 'Le {field} est obligatoire, veuillez indiquer l\' {field}',
                        'valid_email' => 'L\' {field} doit être valide',
                    ],
                ],
            ]
        );


        // On donne des règles de validation une à une ou à travers d'un tableau (setRules)

        $arrErrors = array();
        if (count($this->request->getPost()) > 0){ // Le formulaire a été envoyé ?
            if ($validation->run($this->request->getPost())){ //on teste la validation du formulaire sur les données

                $objUsersModel = new UsersModel(); // Instanciation du modèle
                $objUser = new \App\Entities\User_entity(); // Instanciation de l'entité
                $objUser->fill($this->request->getPost());
                $objUser->hash_password = Hash::make($objUser->hash_password);
                $objUser->isConfirmed = 0;
                
                $objUsersModel->save($objUser); // On sauvegarde l'objet
                return redirect()->to('/Authenticate'); // redirection vers l'action par défaut du controller Product
                //log_message('error', $objUser->hash_password);
        }else{
            $arrErrors = $validation->getErrors(); // on récupère les erreurs pour les afficher
        }
    }

        $data['arrErrors'] = $arrErrors;

        $data['form_open'] = form_open("Authenticate/register");
        $data['label_username'] = form_label("Pseudo", "username");
        $data['form_username'] = form_input("username", $this->request->getPost('username')??"", "id='username'");
        $data['label_mail'] = form_label("Adresse mail", "mail");
        $data['form_mail'] = form_input("mail", $this->request->getPost('mail')??"", "id='mail'");
        $data['label_hash_password'] = form_label("Mot de passe", "hash_password");
        $data['form_hash_password'] = form_input("hash_password", $this->request->getPost('hash_password')??"", "id='hash_password' type='password'");
        $data['label_cmdp'] = form_label("Confirmation mot de passe", "user_cmdp");
        $data['form_cmdp'] = form_input("user_cmdp", $this->request->getPost('user_cmdp')??"", "id='user_cmdp' type='password'");
        $data['form_submit'] = form_submit("submit", "Création du compte");
        $data['form_close'] = form_close();
        echo view('auth/signup_view', $data);
    }
}
