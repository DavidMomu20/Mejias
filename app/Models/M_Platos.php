<?php 
namespace App\Models;

use CodeIgniter\Model;

class M_Platos extends M_base {

    protected $table      = 'platos';
    protected $primaryKey = 'id_plato';

    /**
     * Método para obtener los platos junto con sus alérgenos
     * en función de la categoría pasada como parámetro.
     */

}