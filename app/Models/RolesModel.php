<?php

namespace App\Models;

use CodeIgniter\Model;

class RolesModel extends Model
{
    protected $table = 'role';
    protected $primaryKey = 'role_id';
    protected $returnType = 'App\Entities\Role_entity';
    protected $useTimestamps = false;
}