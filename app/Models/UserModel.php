<?php
 
namespace App\Models;
use CodeIgniter\Model;
 
class UserModel extends Model
{
    // Nom de la table à utiliser
    protected $table         = 'user';
    // Nom du champ de la clé primaire
    protected $primaryKey    = 'user_id';
    // Champs utilisables
    protected $allowedFields = ['username', 'hash_password', 'mail', 'isConfirmed', 'picture_url', 'role'];
 
    // Type de retour => Chemin de l'entité à utiliser
    protected $returnType    = 'App\Entities\UserEntity';
 
    // Utilisation ou non des dates (création / modification)
    protected $useTimestamps = false;
 
}