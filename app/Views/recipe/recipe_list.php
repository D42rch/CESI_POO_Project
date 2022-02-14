<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $name; ?></title>
    <link rel="shortcut icon" type="image/png" href="<?php echo base_url('favicon.ico');?>"/>
</head>
<body>
    <h1><?php echo $name; ?></h1>
    <table>       
        <div id="results" data-url="<?php if(!empty($food_url)) echo $food_url ?>">
            <?php if(!empty($arrRecipe)){         
                foreach($arrRecipe['results'] as $key => $item) {
                    echo $item['title'];
                    echo '<img id="' . $item['id'] . '" src="' . $item['image'] .'" alt=""/><br/>';
            }   
        }?>
        </div>
    </table>
</body>
</html>

