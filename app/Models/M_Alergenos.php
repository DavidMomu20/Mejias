<?php 
namespace App\Models;

use CodeIgniter\Model;

class M_Alergenos extends M_base {

    protected $table      = 'alergenos';
    protected $primaryKey = 'id_alergeno';

    public function dameAlergenosPlato(int $plato)
    {
        return $this->select("alergenos.foto")
                    ->join('platos_alergenos', 'platos_alergenos.id_alergeno = alergenos.id_alergeno')
                    ->join('platos', 'platos_alergenos.id_plato = platos.id_plato')
                    ->where('platos.id_plato', $plato)
                    ->findAll();
    }

}