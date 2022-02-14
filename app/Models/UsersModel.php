<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'user_id';
    protected $allowedFields = ['username', 'hash_password', 'mail', 'isConfirmed', 'picture_url', 'role'];
    protected $returnType = 'App\Entities\User_entity';
    protected $useTimestamps = false;
}