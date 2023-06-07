<?php 
namespace App\Controllers;

use CodeIgniter\Controller;

use App\Models\M_Usuarios;
use App\Models\M_Roles;

class Usuarios extends BaseController {

    public function crud()
    {
        $mUser = new M_Usuarios();
        $mRoles = new M_Roles();

        $data["usuarios"] = $mUser->obtenerRegistros();
        $data["roles"] = $mRoles->obtenerRegistros([], ["id_rol", "nombre"]);
        $data["cuerpo"] = view("admin/cruds/usuarios", $data);

        return view('template/admin', $data);
    }

}