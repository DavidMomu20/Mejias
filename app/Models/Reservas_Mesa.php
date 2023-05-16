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

    /**
     * Método para actualizar los datos de una reserva
     */

    public function updateReservaMesa(int $id, array $datos)
    {
        // Verificar que el ID sea válido
        if (!is_numeric($id) || $id <= 0) {
            return false;
        }

        // Verificar que los datos sean un array y no estén vacíos
        if (!is_array($datos) || empty($datos)) {
            return false;
        }

        // Filtrar y sanitizar los datos
        $datosFiltrados = [
            'id_mesa' => filter_var($datos['id_mesa'], FILTER_SANITIZE_NUMBER_INT),
            'id_estado' => filter_var($datos['id_estado'], FILTER_SANITIZE_NUMBER_INT),
        ];

        // Realizar la actualización del registro
        try {
            $this->update($id, $datosFiltrados);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}