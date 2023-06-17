<?php 
namespace App\Models;

use CodeIgniter\Model;

class M_Platos extends M_base {

    protected $table      = 'platos';
    protected $primaryKey = 'id_plato';

    /**
     * Método para obtener todas las comandas con los datos correspondientes.
     * En esta función se hará los filtros del crud
     */

    public function damePlatos(?array $datos = null)
    {
        $platos = $this->select("platos.*, categorias.descripcion as categoria")
                        ->join("categorias", "platos.id_categoria = categorias.id_categoria");

        if (!is_null($datos))
        {
            
        }
        
        return $platos;
    }

}