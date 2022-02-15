<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $title; ?></title>
</head>
<body>
<h2><?php echo $title; echo $userInfos->username; ?></h2>
<br>
<?php if(!empty(session("message"))) : ?>
    <div class="alet-alert"><?php echo session("message"); ?></div>
<?php endif ?>
<nav>
    <ul>
        <li><a href="<?php echo site_url('Home') ?>">Accueil</a></li>
    </ul>
</nav>  	
<table>
    <tbody>
    <?php foreach($arrRecipes as $row){ ?>
        <tr>
            <td><img src="<?php echo $row->image_URL;?>" alt="Recette" width="500" height="400"></td>

            <td><?php echo $row->name;?></td>
            <td><?php echo $row->owner;?></td>
            <td><?php echo $arrState[$row->state_id];?></td>
            <td><a href="<?php echo site_url('Moderator/updateRecipe/'.$row->recipe_id);?>">Modifier</a>
                <a href="<?php echo site_url('Moderator/delete/'.$row->recipe_id);?>">Supprimer</a></td>
        </tr>
    <?php } ?>
    </tbody>
</table>
</body>
</html>
