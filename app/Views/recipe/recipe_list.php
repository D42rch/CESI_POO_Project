<?php 
    //remplacer apiKey 
    $food_url='https://api.spoonacular.com/recipes/complexSearch?number=10&apiKey=a986bb3f492143e3bbb67f5c4080a2cb';
    $food_json = file_get_contents($food_url);
    $food_array = json_decode($food_json, true);    
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $name; ?></title>
    <link rel="shortcut icon" type="image/png" href="<?php echo base_url('favicon.ico'); ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('/css/style.css'); ?>" />
    
</head>

<body>
    <h1><?php echo $name; ?></h1>



    <?php
    if(isset($search_mode) && $search_mode == true) {
        echo $form_open;
        
        echo $label_title;
        echo $form_title;
        
        echo $label_type;
        echo $form_type;

        echo $label_time;
        echo $input_time;

        echo $form_submit;
        echo $form_close;
    } else {
    ?>
        <a href="<?php echo site_url('recipe/search') ?>">Rechercher des recettes</a>
    <?php
    }
    ?>




    <table>
        <div id="results" data-url="<?php if (!empty($food_url)) echo $food_url ?>">
            <?php if (!empty($arrRecipe) && isset($arrRecipe) && !$no_results ) {

                foreach ($arrRecipe['results'] as $key => $item) {
                    echo $item['title'];
                    echo '<img id="' . $item['id'] . '" src="' . $item['image'] . '" alt=""/><br/>';
                }

            } ?>
        </div>
    </table>

</body>

</html>