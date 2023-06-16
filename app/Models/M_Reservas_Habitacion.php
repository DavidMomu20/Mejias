<?php 
namespace App\Models;

use CodeIgniter\Model;

class M_Reservas_Habitacion extends M_base {

    protected $table      = 'reservas_hab';
    protected $primaryKey = 'id_reserva_hab';
    protected $allowedFields = ["id_usuario", "id_habitacion", "id_estado", "fecha_inicio", "fecha_fin", "n_huespedes", "puntos_usados"];

    /**
     * Método para obtener todas las reservas con los datos correspondientes.
     * En esta función se hará los filtros del crud
     */

    public function dameReservasHab(?array $datos = null)
    {
        $reservas = $this->select("reservas_hab.*, habitaciones.num_habitacion, estados.descripcion AS estado, usuarios.email")
            ->join("estados", "reservas_hab.id_estado = estados.id_estado")
            ->join("habitaciones", "reservas_hab.id_habitacion = habitaciones.id_habitacion")
            ->join("usuarios", "reservas_hab.id_usuario = usuarios.id_usuario");

        if (!is_null($datos))
        {
            if (!empty($datos["fechaInicio"]))
                $reservas->where("reservas_hab.fecha_inicio >=", $datos["fechaInicio"]);

            if (!empty($datos["estado"]))
                $reservas->where("reservas_hab.id_estado", $datos["estado"]);

            if (!empty($datos["nHuespedes"]))
                $reservas->where("reservas_hab.n_comensales", $datos["nHuespedes"]);

            if (!empty($datos["usuario"]))
                $reservas->where("reservas_hab.id_usuario", $datos["usuario"]);

            if (!empty($datos["fechaFin"]))
                $reservas->where("reservas_hab.fecha_fin <=", $datos["fechaFin"]);
        }

        return $reservas;
    }

    /**
     * Método para obtener todas las reservas pendientes
     */

    public function dameReservasHabPendientes()
    {
        $db = \Config\Database::connect();

        $query = $db->table("reservas_hab rh")
            ->select("rh.*, u.nombre, u.apellido, u.telefono, h.foto, h.num_habitacion, h.precio")
            ->join("usuarios u", "rh.id_usuario = u.id_usuario")
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
             ->join("usuarios u", "rh.id_usuario = u.id_usuario")
             ->join("habitaciones h", "rh.id_habitacion = h.id_habitacion")
             ->where("rh.id_estado", 1)
             ->where("rh.fecha_inicio >=", date("Y/m/d"))
             ->where("rh.fecha_fin <=", date("Y/m/d"))
             ->get();
 
         return $query->getResult();
     }
}