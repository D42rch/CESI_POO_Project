<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>

</head>

<body>

    <h2><?php echo $title; ?></h2>

    <br>
    <?php if (!empty(session("message"))) : ?>
        <div class="alet-alert"><?php echo session("message"); ?></div>
    <?php endif ?>
    <br><br>

    <div>

        <?php
        echo $form_open;
        echo $label_url;
        echo $input_url;
        echo $form_submit;
        echo $form_close;
        ?>

    </div>


    <div>

        
        <?php if(ISSET($recipe_json)) echo $recipe_json ?>


    </div>

    <?php
    if (count($arrErrors) > 0) {
    ?>
        <div class="error">
        <?php
        foreach ($arrErrors as $strError) {
            echo "<p>" . $strError . "</p>";
        }
    }
        ?>
        </div>

</body>

</html>