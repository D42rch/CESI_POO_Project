<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{
    protected $table = 'user';
    protected $primarykey = 'user_id';
    protected $allowedFields = ['username', 'hash_password', 'mail', 'isConfirmed', 'picture_url'];
    protected $returnType = 'App\Entities\User_entity';
    protected $useTimestamps = false;
}