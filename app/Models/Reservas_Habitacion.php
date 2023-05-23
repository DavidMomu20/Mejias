<?php 
namespace App\Models;

use CodeIgniter\Model;

class Reservas_Habitacion extends M_base {

    protected $table      = 'reservas_hab';
    protected $primaryKey = 'id_reserva_hab';

    /**
     * Método para insertar una reserva en reservas_hab y usuarios_reservas_hab
     */

    public function insertReservaHab(array $data, int $id_user)
    {
        if ($newId = $this->insertRegistro($data)) 
        {
            $db = \Config\Database::connect();
            $builder = $db->table("usuarios_reservas_hab");

            $datos = [
                "id_usuario" => $id_user, 
                "id_reserva_hab" => $newId
            ];

            return $builder->insert($datos);
        }
    }

}