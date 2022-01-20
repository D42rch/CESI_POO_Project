<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $title; ?></title>
</head>
<body>
<h2><?php echo $title; ?></h2>
<br>
<?php
    echo $form_open;
    //echo $form_id;
    echo $label_username;
    echo $form_username;
    echo $label_mail;
    echo $form_mail;
    echo $label_hash_password;
    echo $form_hash_password;
    echo $label_cmdp;
    echo $form_cmdp;
    echo $form_submit;
    echo $form_close;
?>

<div class="lnksignin">
    <a href="<?php echo site_url('Authenticate/index') ?>">J'ai déjà un compte</a>
</div>
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
    </div>


</body>
</html>
