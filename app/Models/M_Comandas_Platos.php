<?php 
namespace App\Models;

use CodeIgniter\Model;

class M_Comandas_Platos extends M_base {

    protected $table      = 'comandas_platos';
    protected $primaryKey = 'id_comanda_plato';
    protected $allowedFields = ["id_comanda", "id_plato", "racion_plato", "n_unidades"];
    
}