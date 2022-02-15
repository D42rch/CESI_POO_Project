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
            <label for="username">Nouveau pseudonyme</label>
            <input id="username" type="text" name="username">
            <input type="submit" />
        </form>
    </body>
</html>