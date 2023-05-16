<?php 
namespace App\Controllers;

use CodeIgniter\Controller;

use App\Models\Usuarios;

class Login extends Controller {

    public function doLogin()
    {
        $email = $this->request->getPost('email-login');
        $password = $this->request->getPost('password-login');
        $rememberMe = ($this->request->getPost('rememberMe')) ? true : false;

        $mUser = new Usuarios();
        if ($user = $mUser->buscaUsuario($email, $password))
        {
            $permisos = $mUser->damePermisosUser($user["id_usuario"]);

            $session = session();
            $session->set('logged_in', true);
            $session->set('id_user', $user["id_usuario"]);
            $session->set('permisos_user', $permisos);
            $session->set('full_name', $user["nombre"] . " " . $user["apellido"]);
            
            if ($permisos["perm7"] == 1)
                return redirect()->to(base_url());
            else
                return redirect()->to(base_url("admin"));
        }
        else
            return redirect()->to(base_url());
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to(base_url());
    }

}