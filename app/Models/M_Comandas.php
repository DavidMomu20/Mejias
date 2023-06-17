<?php 
namespace App\Models;

use CodeIgniter\Model;

class M_Comandas extends M_base {

    protected $table      = 'comandas';
    protected $primaryKey = 'id_comanda';
    protected $allowedFields = ["id_mesa", "fecha", "hora", "precio_total"];

    /**
     * Método para obtener todas las comandas con los datos correspondientes.
     * En esta función se hará los filtros del crud
     */

    public function dameComandas(?array $datos = null)
    {
        $comandas = $this;

        if (!is_null($datos))
        {
            if (!empty($datos["fecha"]))
                $comandas->where("fecha >=", $datos["fecha"]);

            if (!empty($datos["hora"]))
                $comandas->where("hora >=", $datos["hora"]);

            if (!empty($datos["precioTotal"]))
                $comandas->where("precio_total >=", $datos["precioTotal"]);
        }

        return $comandas;
    }

    /**
     * Método para eliminar todos los platos asociados al 
     * id de la comanda.
     */

    public function eliminaPlatosComanda(int $id_comanda)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('comandas_platos');
    
        try {
            $builder->where('id_comanda', $id_comanda);
            $builder->delete();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

}