<?php
namespace App\Libraries;
use App\Models\RolesModel;

class Usage {

    public static function search_role($id){
        $objRolesModel = new RolesModel(); // Instanciation du modèle
        $role = $objRolesModel->where('role_id', $id)->first();
        $label = $role->label;
        return $label;
    }
}