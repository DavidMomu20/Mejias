<?php 
namespace App\Models;

use CodeIgniter\Model;

class M_Platos extends M_base {

    protected $table      = 'platos';
    protected $primaryKey = 'id_plato';
    protected $allowedFields = ["id_categoria", "nombre", "precio_entera", "precio_media", "imagen"];

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
            if (!empty($datos["id_categoria"]))
                $platos->where("platos.id_categoria", $datos["id_categoria"]);

            if (!empty($datos["precio_entera"]))
                $platos->where("platos.precio_entera >=", $datos["precio_entera"]);
        }
        
        return $platos;
    }

    /**
     * Método para eliminar todos las comandas que poseen
     * el id_plato a borrar.
     */

    public function eliminaComandasConPlato(int $id_plato)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('comandas_platos');
    
        try {
            $builder->where('id_plato', $id_plato);
            $builder->delete();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Método para eliminar todos los alergenos del plato
     * seleccionado
     */

     public function eliminaAlergenosPlato(int $id_plato)
     {
         $db = \Config\Database::connect();
         $builder = $db->table('platos_alergenos');
     
         try {
             $builder->where('id_plato', $id_plato);
             $builder->delete();
             return true;
         } catch (\Exception $e) {
             return false;
         }
     }

}