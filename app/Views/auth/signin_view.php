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
<?php if(!empty(session("message"))) : ?>
    <div class="alet-alert"><?php echo session("message"); ?></div>
<?php endif ?>
<br><br>
<?php
    echo $form_open;
    echo $label_username;
    echo $form_username;
    echo $label_hash_password;
    echo $form_hash_password;
    echo $form_submit;
    echo $form_close;
?>
<br><br>
<div class="lnksignup"><a href="<?php echo site_url('Authenticate/register') ?>">Je n'ai pas encore de compte</a></div>
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
