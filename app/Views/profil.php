
<!DOCTYPE html">
<html lang="fr">
  <head>
    <meta charset="utf-8" />
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" type="text/css" href="<?= base_url('stylesheets/styleProfil.css') ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
  </head>
  
  <body> <!-- beware ! lots of placeholders, it includes : IMG, pseudo, Role, email, mot de passe-->
  <div class="container">
    <div class="shadow-lg w-100 p-3 mb-5 bg-white rounded">
        <p class="increase-font-size"><?php echo $title; ?></p>
        <hr>	
        <p><a href="<?php echo previous_url();?>">Retour</a></p>
        <div class="form-row">
        <div class="d-flex justify-content-center position-relative md-12">
          <img src="" width="150px" alt="Profile picture">
        </div>
        <div class="form-group col-md-12">
            <label for="inputEmail4"><b>Pseudonyme : </b><?php echo $user->username; ?></label>
        </div>
        <div class="form-group col-md-12">
            <label for="inputEmail4"><b>Rôle : </b><?php echo $user->role; ?></label>
        </div>
        <div class="form-group col-md-12">
            <label for="inputEmail4"><b>Email : </b><?php echo $user->mail; ?></label>
        </div>
        </div>
        <p class="increase-font-size">Paramètres</p>
        <hr>
        <div class="form-row">
        <div class="form-group col-md-12">
          <a class="btn" href="<?php echo site_url('Profilecontroller/usernameEdit/'.strval($user->user_id))?>">Changer votre pseudonyme</a>
        </div>
        <div class="form-group col-md-12">
          <a class="btn" href="<?php echo site_url('Profilecontroller/mailEdit/'.strval($user->user_id))?>">Changer votre addresse mail</a>
        </div>
        <div class="form-group col-md-12">
          <a class="btn" href="<?php echo site_url('Profilecontroller/pwdEdit/'.strval($user->user_id))?>">Changer votre mot de passe</a>
        </div>
        
        </div>
    </div>  
  </div> 
  </body>
</html>