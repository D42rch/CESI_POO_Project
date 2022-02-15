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
        <li><a href="<?php echo site_url('Moderator/recipe_list') ?>">Liste des recettes à publier</a></li>
    </ul>
</nav>  	
<?php
    echo $form_open;
    echo $label_state;
    echo $form_state;
    echo $form_submit;
    echo $form_close;
?>
</body>
</html>
