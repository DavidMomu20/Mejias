<?php 
namespace App\Models;

use CodeIgniter\Model;

class M_Mesas extends M_base{
    protected $table      = 'mesas';
    protected $primaryKey = 'id_mesa';

    /**
     * Método para obtener todas aquellas mesas cuyas reservas de mesa estén confirmdas para el día de hoy
     */

    public function dameMesasDeHoy()
    {   
        $mesas = $this->select("mesas.id_mesa")
                        ->join("reservas_mesa", "reservas_mesa.id_mesa = mesas.id_mesa")
                        ->join("estados", "reservas_mesa.id_estado = estados.id_estado")
                        ->where("reservas_mesa.id_estado", 1)
                        ->where("reservas_mesa.fecha", date('Y-m-d'))
                        ->findAll();

        return $mesas;
    }

    /**
     * Obtener todas las mesas con el número máximo de comensales
     *
     * @param int $n_comensales Número de comensales para buscar
     * @return array Arreglo de objetos de mesa
     */

    public function dameMesasNComensales(int $n_comensales): array
    {
        // Verificar que el número de comensales sea válido
        if ($n_comensales <= 0) {
            throw new InvalidArgumentException('El número de comensales debe ser mayor que cero');
        }

        // Obtener todas las mesas con el número máximo de comensales
        $mesas = $this->where('max_comensales', $n_comensales)->findAll();

        return $mesas;
    }
}