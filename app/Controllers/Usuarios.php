<?php 
namespace App\Controllers;

use CodeIgniter\Controller;

use App\Models\M_Usuarios;
use App\Models\M_Roles;

class Usuarios extends BaseController {

    /**
     * Método para que el usuario pueda cambiar los datos de su cuenta.
     */

    public function cambiarDatos()
    {
        $nombre = $this->request->getPost('nombre');
        $apellido = $this->request->getPost('apellido');
        $email = $this->request->getPost('email');
        $telefono = $this->request->getPost('telefono');

        $data = [
            'nombre' => $nombre,
            'apellido' => $apellido,
            'email' => $email,
            'telefono' => $telefono
        ];

        $validaciones = [
            'nombre' => 'required',
            'apellido' => 'required',
            'email' => 'required|valid_email',
            'telefono' => 'required|numeric|min_length[9]'
        ];

        if ($this->validate($validaciones))
        {
            $mUser = new M_Usuarios();

            $id_user = intval(session()->get('id_user'));

            if ($mUser->updateRegistro($id_user, $data))
                echo json_encode(["data" => "success"]);
            else
                echo json_encode(["data" => "errorBadUpdate"]);
        }
        else 
            echo json_encode(["data" => "errorIncorrectData"]);
    }

    /**
     * Método para que el usuario pueda cambiar su contraseña
     */

    public function cambiarPassword()
    {
        $password = $this->request->getPost("contra");
        $repeat_password = $this->request->getPost("repeatContra");

        $data = [
            "password" => $password, 
            "repeat_password" => $repeat_password
        ];

        /*
        $validaciones = [
            'password' => 'required',
            'repeat_password' => 'required|matches[password]'
        ];
        */

        if ($password === $repeat_password) // $this->validate($validaciones)
        {
            $data = [
                "password" => password_hash($data["password"], PASSWORD_DEFAULT)
            ];

            $mUser = new M_Usuarios();

            $id_user = intval(session()->get('id_user'));

            if ($mUser->updateRegistro($id_user, $data))
                echo json_encode(["data" => "success"]);
            else
                echo json_encode(["data" => "errorBadUpdate"]);
        }
        else 
            echo json_encode(["data" => "errorIncorrectData"]);
    }

    /**
     * ========= MÉTODOS CRUD =========
     */

    public function crud()
    {
        $mRoles = new M_Roles();

        $data["roles"] = $mRoles->obtenerRegistros([], ["id_rol", "nombre"])->findAll();
        $data["cuerpo"] = view("admin/cruds/usuarios", $data);

        return view('template/admin', $data);
    }

    public function ajax()
    {
        $mUser = new M_Usuarios();

        $usuarios = $mUser->dameUsuarios();
        $columnas = ["nombre", "apellido", "rol", "email", "telefono", "puntos", "borrado"];

        return $this->ajaxCrud($usuarios, $columnas);
    }

    public function update()
    {
        $mUser = new M_Usuarios();

        $id_usuario = $this->request->getPost("id_usuario");
        $id_rol = $this->request->getPost("id_rol");
        $nombre = $this->request->getPost("nombre");
        $apellido = $this->request->getPost("apellido");
        $email = $this->request->getPost("email");
        $telefono = $this->request->getPost("telefono");
        $puntos = $this->request->getPost("puntos");

        $data = [
            "id_rol" => $id_rol, 
            "nombre" => $nombre, 
            "apellido" => $apellido, 
            "email" => $email, 
            "telefono" => $telefono, 
            "puntos" => $puntos
        ];

        if ($mUser->updateRegistro($id_usuario, $data))
            return json_encode(["data" => "Registro modificado con éxito"]);
    }

}