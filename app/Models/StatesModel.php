<?php

namespace App\Models;

use CodeIgniter\Model;

class StatesModel extends Model
{
    protected $table = 'recipestate';
    protected $primaryKey = 'RS_id';
    protected $returnType = 'App\Entities\State_entity';
    protected $useTimestamps = false;
}