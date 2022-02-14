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
<h2><?php echo $title; echo $session->get('user');?></h2>
<br>
<nav>
    <ul>
        <li><a href="<?php echo site_url('Home') ?>">Accueil</a></li>
    </ul>
</nav>  
<h3>Voulez vous vraiement supprimer ce profil</h3>	
<?php
    echo $form_open;
    echo $form_id;
    echo $label_username;
    echo $form_username;
    echo $label_mail;
    echo $form_mail;
    echo $form_submit;
    echo $form_close;
?>

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
