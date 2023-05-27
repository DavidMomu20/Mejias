<?php 
namespace App\Controllers;

use CodeIgniter\Controller;

use App\Models\M_Usuarios;

class Login extends Controller {

    public function doLogin()
    {
        $email = $this->request->getPost('email_login');
        $password = $this->request->getPost('password_login');
        $rememberMe = ($this->request->getPost('rememberMe')) ? true : false;

        $mUser = new M_Usuarios();
        if ($user = $mUser->buscaUsuario($email, $password))
        {
            $permisos = $mUser->damePermisosUser($user["id_usuario"]);

            $session = session();
            $session->set('logged_in', true);
            $session->set('id_user', $user["id_usuario"]);
            $session->set('permisos_user', $permisos);
            $session->set('full_name', $user["nombre"] . " " . $user["apellido"]);
            
            if ($permisos["perm7"] == 1)
                echo json_encode(["data" => base_url()]);
            else
                echo json_encode(["data" => base_url("admin")]);
        }
        else
            echo json_encode(["data" => "error"]);
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to(base_url());
    }

}