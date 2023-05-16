<?php 
namespace App\Models;

use CodeIgniter\Model;

class Mesas extends Model{
    protected $table      = 'mesas';
    protected $primaryKey = 'id_mesa';

    /**
     * Función para obtener todas las mesas
     */

    public function dameMesas()
    {
        return $this->findAll();
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