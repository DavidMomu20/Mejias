<?php 
namespace App\Controllers;

use CodeIgniter\Controller;

use App\Models\M_Usuarios;
use App\Models\M_Roles;

class Usuarios extends BaseController {

    /**
     * --- Mis variables de instancia ---
     */

    private array $rules = [
                    'id_rol' => 'required',
                    'nombre' => 'required',
                    'apellido' => 'required',
                    'email' => 'required|valid_email',
                    'telefono' => 'required',
                    'puntos' => 'permit_empty|numeric'
                ];

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

    /**
     * Acceder a crud
     */

    public function crud()
    {
        $mUser = new M_Usuarios();
        $mRoles = new M_Roles();

        $usuarios = $mUser->dameUsuarios()->paginate(5);

        $data["usuarios"] = $usuarios;
        $data["pager"] = $mUser->pager;
        $data["roles"] = $mRoles->obtenerRegistros([], ["id_rol", "nombre"])->findAll();
        $data["cuerpo"] = view("admin/cruds/usuarios", $data);

        return view('template/admin', $data);
    }

    /**
     * Método FILTRAR
     */

    public function filtrar()
    {
        $mUser = new M_Usuarios();
        $mRoles = new M_Roles();

        $correo = $this->request->getVar('correo');
        $idRol = $this->request->getVar('roles');
        $telefono = $this->request->getVar('telefono');
        $borrado = $this->request->getVar('borrado');
        $nRegistros = $this->request->getVar('n-registros');

        // Aplicar los filtros según los valores recibidos
        $usuarios = $mUser->dameUsuarios();
        if (!empty($correo))
            $usuarios->like('usuarios.email', $correo);

        if (!empty($idRol))
            $usuarios->where('usuarios.id_rol', $idRol);
        
        if (!empty($telefono))
            $usuarios->like('usuarios.telefono', $telefono);

        if ($borrado == 'si')
            $usuarios->where('usuarios.borrado', 1);
        else
            $usuarios->where('usuarios.borrado', 0);

        $usuarios = $usuarios->paginate($nRegistros);

        $data["usuarios"] = $usuarios;
        $data["pager"] = $mUser->pager;
        $data["roles"] = $mRoles->obtenerRegistros([], ["id_rol", "nombre"])->findAll();
        $data["cuerpo"] = view("admin/cruds/usuarios", $data);

        return view('template/admin', $data);
    }

    /**
     * Método CREAR
     */

    public function create()
    {
        $mUser = new M_Usuarios();

        $id_rol = $this->request->getPost("id_rol");
        $nombre = $this->request->getPost("nombre");
        $apellido = $this->request->getPost("apellido");
        $email = $this->request->getPost("email");
        $password = $this->request->getPost("password");
        $telefono = $this->request->getPost("telefono");
        $puntos = $this->request->getPost("puntos");

        $rules = $this->rules;
        $rules["password"] = "required";

        if(empty($puntos))
            $puntos = null;

        // Realizo la validación de los datos
        if (!$this->validate($rules)) {
            // La validación falló, devuelvo los mensajes de error
            $errors = $this->validator->getErrors();
            return json_encode(['error' => $errors]);
        }

        // Los datos son válidos, procedo a actualizar el registro
        $data = [
            "id_rol" => $id_rol,
            "nombre" => $nombre,
            "apellido" => $apellido,
            "email" => $email,
            "password" => $password,
            "telefono" => $telefono,
            "puntos" => $puntos, 
            "borrado" => false
        ];

        if ($newId = $mUser->insertaUsuario($data)) {
            $mRoles = new M_Roles();
            $data["rol"] = $mRoles->obtenerRegistros(["id_rol" => $data["id_rol"]])["nombre"];
            $data["id_usuario"] = $newId;
            return json_encode($data);
        }
    }

    /**
     * Método ACTUALIZAR
     */

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

        if(empty($puntos))
            $puntos = null;

        // Realizo la validación de los datos
        if (!$this->validate($this->rules)) {
            // La validación falló, devuelvo los mensajes de error
            $errors = $this->validator->getErrors();
            return json_encode(['error' => $errors]);
        }

        // Los datos son válidos, procedo a actualizar el registro
        $data = [
            "id_rol" => $id_rol,
            "nombre" => $nombre,
            "apellido" => $apellido,
            "email" => $email,
            "telefono" => $telefono,
            "puntos" => $puntos
        ];

        if ($mUser->updateRegistro($id_usuario, $data)) {
            $mRoles = new M_Roles();
            $data["rol"] = $mRoles->obtenerRegistros(["id_rol" => $data["id_rol"]])["nombre"];
            return json_encode($data);
        }
    }

    /**
     * Método ELIMINAR
     */

    public function delete()
    {
        $mUser = new M_Usuarios();

        $id_usuario = $this->request->getPost('id_usuario');

        $data = [
            "borrado" => 1
        ];

        if ($mUser->updateRegistro($id_usuario, $data))
        {
            return json_encode($data);
        }
    }
}