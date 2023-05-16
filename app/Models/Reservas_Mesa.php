<?php 
namespace App\Models;

use CodeIgniter\Model;

class Reservas_Mesa extends Model {

    protected $table      = 'reservas_mesa';
    protected $primaryKey = 'id_reserva_mesa';
    protected $allowedFields = ["id_estado", "fecha", "hora", "n_comensales"];

    /**
     * Método para obtener todas aquellas incidencias que esten pendientes de confirmar
     */

    public function dameReservasMesaPendientes()
    {
        $db = \Config\Database::connect();
        
        $query = $db->table('reservas_mesa rm')
             ->select('rm.*, u.nombre, u.apellido, u.telefono')
             ->join('usuarios_reservas_mesa urm', 'rm.id_reserva_mesa = urm.id_reserva_mesa')
             ->join('usuarios u', 'urm.id_usuario = u.id_usuario')
             ->where('rm.id_estado', 6)
             ->get();
        
        return $query->getResult();
    }

    /**
     * Métoodo para insertar una nueva reserva de mesa
     */

    public function insertReservaMesa(array $data, int $id_user)
    {
        $this->insert($data);

        if ($newId = $this->insertID()) {

            $db = \Config\Database::connect();
            $builder = $db->table("usuarios_reservas_mesa");

            $datos = [
                "id_usuario" => $id_user, 
                "id_reserva_mesa" => $newId
            ];

            return $builder->insert($datos);
        }
    }
}