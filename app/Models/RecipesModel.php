<?php

namespace App\Models;

use CodeIgniter\Model;

class RecipesModel extends Model
{
    protected $table = 'recipe';
    protected $primaryKey = 'recipe_id';
    protected $allowedFields = ["api_source_id","owner","state_id","isPublish","checksum","name","image_URL","servings","readyInMinutes","source_URL","api_source_URL","nutrition_id","likes","healthScore","pricePerServing","isCheap","cuisines","dairyFree","instructions","diets","glutenFree","ketogenic","lowFodmap","vegan","vegatarian","veryHealthy","veryPopular","whole30","dishType","summary","pairedWines","pairedWinesText"];
    protected $returnType = 'App\Entities\Recipe_entity';
    protected $useTimestamps = true;
}
