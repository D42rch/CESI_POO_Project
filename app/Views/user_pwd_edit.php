<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title><?php echo $title; ?></title>
    </head>
    <body>
        <h1><?php echo $title; ?></h1>
        <p><a href="<?php echo previous_url();?>">Retour</a></p>
        <form action="#" method="post">
            <label for="hash_password">Nouveau mot de passe</label>
            <input id="hash_password" type="text" name="hash_password">
            <input type="submit" />
        </form>
    </body>
</html>