<?php 
namespace App\Models;

use CodeIgniter\Model;

class M_Usuarios extends M_base{
    protected $table      = 'usuarios';
    protected $primaryKey = 'id_usuario';
    protected $allowedFields = ["id_rol", "nombre", "apellido", "email", "password", "telefono"];

    /**
     * Método para buscar un usuario a través de su ID
     */

    public function buscaUsuarioById(int $id)
    {
        $usuario = $this->where('id_usuario', $id)
                        ->where('borrado', false)
                        ->first();

        if ($usuario)
            return $usuario;

        return false;
    }

    /**
     * Método para buscar un usuario dado su email y contraseña
     */

    public function buscaUsuario(string $email, string $password)
    {
        $usuario = $this->where('email', $email)
                        ->where('borrado', false)
                        ->first();

        // password_verify($password, $usuario['password'])
                    
        if ($usuario && password_verify($password, $usuario['password']))
            return $usuario;

        return false;
    }

    /**
     * Método para insertar un nuevo usuario en la tabla
     */

    public function insertaUsuario(array $datos)
    {
        // Hasheo la contraseña utilizando el salt
        $datos["password"] = password_hash($datos["password"], PASSWORD_DEFAULT);

        $this->insert($datos);

        return $this->insertID();
    }

    /**
     * Método para obtener los permisos que posee el usuario a través de su ID
     */

    public function damePermisosUser(int $id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('roles r');

        $permisos = $builder->select('r.perm7, r.perm8, r.perm9, r.perm10')
                        ->join('usuarios u', 'r.id_rol = u.id_rol')
                        ->where('u.id_usuario', $id)
                        ->get()->getResultArray();

        $error = $db->error();
        if ($error["code"] == 0 && !empty($permisos))               
            return $permisos[0];
                
        return null;
    }
}