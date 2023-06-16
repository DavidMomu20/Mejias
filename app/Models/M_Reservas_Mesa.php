<?php 
namespace App\Models;

use CodeIgniter\Model;

class M_Reservas_Mesa extends M_base {

    protected $table      = 'reservas_mesa';
    protected $primaryKey = 'id_reserva_mesa';
    protected $allowedFields = ["id_usuario", "id_mesa", "id_estado", "fecha", "hora", "n_comensales"];

    /**
     * Método para obtener todas las reservas con los datos correspondientes.
     * En esta función se hará los filtros del crud
     */

    public function dameReservasMesa(?array $datos = null)
    {
        $reservas = $this->select("reservas_mesa.*, estados.descripcion AS estado, usuarios.email")
            ->join("estados", "reservas_mesa.id_estado = estados.id_estado")
            ->join("usuarios", "reservas_mesa.id_usuario = usuarios.id_usuario");

        if (!is_null($datos))
        {
            if (!empty($datos["fecha"]))
                $reservas->where("reservas_mesa.fecha >=", $datos["fecha"]);

            if (!empty($datos["estado"]))
                $reservas->where("reservas_mesa.id_estado", $datos["estado"]);

            if (!empty($datos["nComensales"]))
                $reservas->where("reservas_mesa.n_comensales", $datos["nComensales"]);

            if (!empty($datos["usuario"]))
                $reservas->where("reservas_mesa.id_usuario", $datos["usuario"]);
        }

        return $reservas;
    }

    /**
     * Método para obtener todas aquellas reservas de mesa que esten pendientes de confirmar
     */

    public function dameReservasMesaPendientes()
    {   
        $reservas = $this->select("reservas_mesa.*, usuarios.nombre, usuarios.apellido, usuarios.email, usuarios.telefono")
                        ->join("usuarios", "reservas_mesa.id_usuario = usuarios.id_usuario")
                        ->where("reservas_mesa.id_estado", 3);

        return $reservas;
    }

    /**
     * Método para obtener todas aquellas reservas de emsa que esten pendientes de confirmar
     */

     public function dameReservasMesaDeHoy()
     {   
         $reservas = $this->select("reservas_mesa.*, usuarios.nombre, usuarios.apellido, usuarios.email, usuarios.telefono")
                        ->join("usuarios", "reservas_mesa.id_usuario = usuarios.id_usuario")
                        ->where("reservas_mesa.id_estado", 1)
                        ->where("reservas_mesa.fecha", date("Y/m/d"));
                         
         return $reservas;
     }

    /**
     * Método para obtener todas aquellas mesas cuyas reservas de mesa estén confirmdas para el día de hoy
     */

    public function dameMesasDeHoy()
    {   
        $mesas = $this->select("id_mesa")
                        ->where("id_estado", 1)
                        ->where("fecha", date('Y-m-d'))
                        ->findAll();

        return $mesas;
    }

    /**
     * Método para obtener aquellas reservas de mesa cuya fecha coincidan con la pasada por parámetro
     */

    public function dameReservasMesaByFecha(string $fecha)
    {
        $db = \Config\Database::connect();

        $query = $db->table('reservas_mesa')
                    ->where('fecha', $fecha)
                    ->get();

        return $query->getResultArray();
    }
}