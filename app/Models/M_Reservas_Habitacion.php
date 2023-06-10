<?php 
namespace App\Models;

use CodeIgniter\Model;

class M_Reservas_Habitacion extends M_base {

    protected $table      = 'reservas_hab';
    protected $primaryKey = 'id_reserva_hab';
    protected $allowedFields = ["id_habitacion", "id_estado", "fecha_inicio", "fecha_fin", "n_huespedes", "puntos_usados"];

    /**
     * Método para obtener todas las reservas pendientes
     */

    public function dameReservasHabPendientes()
    {
        $db = \Config\Database::connect();

        $query = $db->table("reservas_hab rh")
            ->select("rh.*, u.nombre, u.apellido, u.telefono, h.foto, h.num_habitacion, h.precio")
            ->join("usuarios_reservas_hab urh", "rh.id_reserva_hab = urh.id_reserva_hab")
            ->join("usuarios u", "urh.id_usuario = u.id_usuario")
            ->join("habitaciones h", "rh.id_habitacion = h.id_habitacion")
            ->where("rh.id_estado", 3)
            ->get();

        return $query->getResult();
    }

    /**
     * Método para obtener todas las reservas confirmadas para el dia de hoy
     */

     public function dameReservasHabDeHoy()
     {
         $db = \Config\Database::connect();
 
         $query = $db->table("reservas_hab rh")
             ->select("rh.*, u.nombre, u.apellido, u.telefono, h.foto, h.num_habitacion, h.precio")
             ->join("usuarios_reservas_hab urh", "rh.id_reserva_hab = urh.id_reserva_hab")
             ->join("usuarios u", "urh.id_usuario = u.id_usuario")
             ->join("habitaciones h", "rh.id_habitacion = h.id_habitacion")
             ->where("rh.id_estado", 1)
             ->where("rh.fecha_inicio >=", date("Y/m/d"))
             ->where("rh.fecha_fin <=", date("Y/m/d"))
             ->get();
 
         return $query->getResult();
     }

    /**
     * Método para insertar una reserva en reservas_hab y usuarios_reservas_hab
     */

    public function insertReservaHab(array $data, int $id_user)
    {
        if ($newId = $this->insertarRegistro($data)) 
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