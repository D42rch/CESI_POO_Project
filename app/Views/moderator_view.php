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
    <thead>
    <tr>
        <th>Pseudo</th>
        <th>Adresse mail</th>
        <th>Rôle</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($arrUsers as $row){ ?>
        <tr>
            <td><?php echo $row->username;?></td>
            <td><?php echo $row->mail;?></td>
            <td><?php echo $arrRole[$row->role];?></td>
            <td><a href="<?php echo site_url('Moderator/update/'.$row->user_id);?>">Modifier</a>
                <a href="<?php echo site_url('Moderator/delete/'.$row->user_id);?>">Supprimer</a></td>
        </tr>
    <?php } ?>
    </tbody>
</table>
</body>
</html>
