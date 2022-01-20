<?php

namespace App\Models;

use CodeIgniter\Model;

class RolesModel extends Model
{
    protected $table = 'role';
    protected $primarykey = 'role_id';
    protected $allowedFields = ['read_recipe', 'suggest', 'validate_suggest', 'publish', 'own_edit', 'all_edit', 'own_archive', 'all_archive', 'delete_recipe', 'role_edit'];
    protected $returnType = 'App\Entities\User_entity';
    protected $useTimestamps = false;
}