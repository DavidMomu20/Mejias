<?php 
namespace App\Models;

use CodeIgniter\Model;

class M_Comandas extends M_base {

    protected $table      = 'comandas';
    protected $primaryKey = 'id_comanda';
    protected $allowedFields = ["id_mesa", "fecha", "hora", "precio_total"];

}