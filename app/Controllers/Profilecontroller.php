<?php 
namespace App\Controllers;
 
use CodeIgniter\Controller;
use App\Models\UserModel;
 
class Profilecontroller extends Controller
{
    public function index($primaryKey) {
        
        // Instanciation du modèle
        $objUserModel       = new UserModel();
        
        // On fournit les variables pour la vue
        $data['title'] = "Profil"; // titre
        $data['user'] = $objUserModel->find($primaryKey);
        // Affichage de la vue
        echo view('profil',$data);
    }

    public function usernameEdit($intId){
        // Déclare l'utilisation du helper
        helper('form');
      
        // Instanciation du modèle
        $objUserModel    = new UserModel();
        // Instanciation de l'entité
        $objUser        = new \App\Entities\UserEntity();
        $data['title']      = "Modifier le pseudonyme";

        $objUser         = $objUserModel->find($intId);

        // Il faut charger la librairie
        $validation =  \Config\Services::validation();
      
        // On donne des règles de validation
        $validation->setRules([
            'username' => [
                'label'  => 'Pseudonyme',
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Le {field} est obligatoire',
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
                $objUserModel->save($objUser);
                // redirection vers l'action par défaut du controller Product
                return redirect()->to('Profilecontroller/index/'.$intId);
            }else{
                // on récupère les erreurs pour les afficher
                $arrErrors = $validation->getErrors();
            }
        }

        $data['arrErrors']      = $arrErrors;
        $data['form_open']      = form_open("Profilecontroller/usernameEdit");
        $data['form_id']        = form_hidden("user_id", $objUser->user_id??'', "id='user_id'");
        $data['label_name']     = form_label("username", "username");
        $data['form_name']      = form_input("username", $objUser->username??'', "id='username'");  
        $data['form_submit']    = form_submit("submit", "Envoyer");
        $data['form_close']     = form_close();
       
           echo view('user_name_edit', $data);
    }

    public function mailEdit($intId){
        // Déclare l'utilisation du helper
        helper('form');
      
        // Instanciation du modèle
        $objUserModel    = new UserModel();
        // Instanciation de l'entité
        $objUser        = new \App\Entities\UserEntity();
        $data['title']      = "Modifier l'adresse mail";

        $objUser         = $objUserModel->find($intId);

        // Il faut charger la librairie
        $validation =  \Config\Services::validation();
      
        // On donne des règles de validation
        $validation->setRules([
            'mail' => [
                'label'  => 'Mail',
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Le {field} est obligatoire',
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
                $objUserModel->save($objUser);
                // redirection vers l'action par défaut du controller Product
                return redirect()->to('Profilecontroller/index/'.$intId);
            }else{
                // on récupère les erreurs pour les afficher
                $arrErrors = $validation->getErrors();
            }
        }

        $data['arrErrors']      = $arrErrors;
        $data['form_open']      = form_open("Profilecontroller/mailEdit");
        $data['form_id']        = form_hidden("user_id", $objUser->user_id??'', "id='user_id'");
        $data['label_name']     = form_label("mail", "mail");
        $data['form_name']      = form_input("mail", $objUser->mail??'', "id='mail'");  
        $data['form_submit']    = form_submit("submit", "Envoyer");
        $data['form_close']     = form_close();
       
           echo view('user_mail_edit', $data);
    }

    public function pwdEdit($intId){
        // Déclare l'utilisation du helper
        helper('form');
      
        // Instanciation du modèle
        $objUserModel    = new UserModel();
        // Instanciation de l'entité
        $objUser        = new \App\Entities\UserEntity();
        $data['title']      = "Modifier le mot de passe";

        $objUser         = $objUserModel->find($intId);

        // Il faut charger la librairie
        $validation =  \Config\Services::validation();
      
        // On donne des règles de validation
        $validation->setRules([
            'hash_password' => [
                'label'  => 'Mot de passe',
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Le {field} est obligatoire',
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
                $objUserModel->save($objUser);
                // redirection vers l'action par défaut du controller Product
                return redirect()->to('Profilecontroller/index/'.$intId);
            }else{
                // on récupère les erreurs pour les afficher
                $arrErrors = $validation->getErrors();
            }
        }

        $data['arrErrors']      = $arrErrors;
        $data['form_open']      = form_open("Profilecontroller/pwdEdit");
        $data['form_id']        = form_hidden("user_id", $objUser->user_id??'', "id='user_id'");
        $data['label_name']     = form_label("hash_password", "hash_password");
        $data['form_name']      = form_input("hash_password", $objUser->hash_password??'', "id='hash_password'");  
        $data['form_submit']    = form_submit("submit", "Envoyer");
        $data['form_close']     = form_close();
       
           echo view('user_pwd_edit', $data);
    }
}