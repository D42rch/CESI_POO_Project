<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $title; ?></title>
</head>
<body>
    <?php $session = session();?>
<h2><?php echo $title; echo $userInfos->username;?></h2>
<br>
<nav>
    <ul>
        <li><a href="<?php echo site_url('Home') ?>">Accueil</a></li>
    </ul>
</nav>  
<p></p>
<h4>Voulez vous vraiement supprimer ce profil ?</h3>	
<?php echo $form_open;?>
<thead>
    <tr>
        <th>Adresse mail : </th>
        <td><?php echo $form_mail;?></td><br><br>
        <th>Pseudo : </th>
        <td><?php echo $form_username;?></td><br><br>
        <th>Rôle : </th>
        <td><?php echo $form_role;?></td>
    </tr>
</thead>
<br><br>
<button><a href="<?php echo site_url('Moderator/delete_user/'.$intId);?>">Supprimer</a></td></button>
<?php echo $form_close;?>
<?php
        if (count($arrErrors) > 0){
    ?>
    <div class="error">
        <?php
            foreach($arrErrors as $strError){
                echo "<p>".$strError."</p>";
            }
        }
        ?>
</body>
</html>
