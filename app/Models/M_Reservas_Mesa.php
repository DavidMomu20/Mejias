<?php 
namespace App\Models;

use CodeIgniter\Model;

class M_Reservas_Mesa extends M_base {

    protected $table      = 'reservas_mesa';
    protected $primaryKey = 'id_reserva_mesa';
    protected $allowedFields = ["id_mesa", "id_estado", "fecha", "hora", "n_comensales"];

    /**
     * Método para obtener todas las reservas con los datos del usuario correspondiente.
     * En esta función se hará los filtros del crud
     */

    public function dameReservasMesa(?array $filtros = null)
    {
        $reservas = $this->select("reservas_mesa.*, estados.descripcion AS estado, usuarios.email, usuarios.telefono")
            ->join("estados", "reservas_mesa.id_estado = estados.id_estado")
            ->join("usuarios_reservas_mesa", "usuarios_reservas_mesa.id_reserva_mesa = reservas_mesa.id_reserva_mesa")
            ->join("usuarios", "usuarios_reservas_mesa.id_usuario = usuarios.id_usuario");

        return $reservas;
    }

    /**
     * Método para obtener todas aquellas incidencias que esten pendientes de confirmar
     */

    public function dameReservasMesaPendientes()
    {   
        $reservas = $this->select("reservas_mesa.*, usuarios.nombre, usuarios.apellido, usuarios.telefono")
                        ->join('usuarios_reservas_mesa', 'reservas_mesa.id_reserva_mesa = usuarios_reservas_mesa.id_reserva_mesa')
                        ->join('usuarios', 'usuarios_reservas_mesa.id_usuario = usuarios.id_usuario')
                        ->where("reservas_mesa.id_estado", 3);

        return $reservas;
    }

    /**
     * Método para obtener aquellas incidencias cuya fecha coincidan con la pasada por parámetro
     */

    public function dameReservasMesaByFecha(string $fecha)
    {
        $db = \Config\Database::connect();

        $query = $db->table('reservas_mesa')
                    ->where('fecha', $fecha)
                    ->get();

        return $query->getResultArray();
    }

    /**
     * Métoodo para insertar una nueva reserva de mesa
     */

    public function insertReservaMesa(array $data, int $id_user)
    {
        if ($newId = $this->insertarRegistro($data))
        {
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