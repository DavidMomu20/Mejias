<?php 
namespace App\Controllers;

use CodeIgniter\Controller;

use App\Models\Usuarios;
use App\Models\Roles;

class Register extends Controller {

    public function doRegister()
    {
        $mUser = new Usuarios();
        $mRol = new Roles();

        $rol = $mRol->dameIdRol('cliente');

        $datos = [
            "id_rol" => $rol,
            "nombre" => $this->request->getPost('nombre'), 
            "apellido" => $this->request->getPost('apellido'), 
            "email" => $this->request->getPost('email-register'), 
            "password" => $this->request->getPost('password-register'), 
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
                return redirect()->to(base_url());
            else
                return redirect()->to(base_url("admin"));
        }

        else
            return redirect()->to(base_url());
    }
}