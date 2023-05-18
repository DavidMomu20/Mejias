<?php 
namespace App\Models;

use CodeIgniter\Model;

class Roles extends M_base{
    protected $table      = 'roles';
    protected $primaryKey = 'id_rol';

    /**
     * Método para obtener todos los roles
     */

    public function dameRoles()
    {
        return $this->findAll();
    }

    /**
     * Método para obtener el id de un rol a partir de su nombre
     */

    public function dameIdRol(string $nombre)
    {
        return $this->select('id_rol')->where('nombre', $nombre)->first()["id_rol"];
    }
}