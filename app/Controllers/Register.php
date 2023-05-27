<?php 
namespace App\Controllers;

use CodeIgniter\Controller;

use App\Models\M_Usuarios;
use App\Models\M_Roles;

class Register extends Controller {

    public function doRegister()
    {
        $mUser = new M_Usuarios();
        $mRol = new M_Roles();

        $rol = $mRol->dameIdRol('cliente');

        $email = $this->request->getPost('email_register');
        $password = $this->request->getPost('password_register');

        if (!$mUser->buscaUsuario($email, $password))
        {
            $datos = [
                "id_rol" => $rol,
                "nombre" => $this->request->getPost('nombre'), 
                "apellido" => $this->request->getPost('apellido'), 
                "email" => $email, 
                "password" => $password, 
                "telefono" => $this->request->getPost('phone')
            ];
    
            if ($id = $mUser->insertaUsuario($datos)) {
    
                $permisos = $mUser->damePermisosUser($id);
    
                $session = session();
                $session->set('logged_in', true);
                $session->set('id_user', $id);
                $session->set('permisos_user', $permisos);
                $session->set('full_name', $datos["nombre"] . " " . $datos["apellido"]);
    
                if ($permisos["perm7"] == 1)
                    echo json_encode(["data" => base_url()]);
                else
                    echo json_encode(["data" => base_url("admin")]);
            }
            else
                echo json_encode(["data" => "errorBadInsert"]);
        }
        else 
            echo json_encode(["data" => "errorNotUserFound"]);
    }
}