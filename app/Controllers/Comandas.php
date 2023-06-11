<?php 
namespace App\Controllers;

use CodeIgniter\Controller;

use App\Models\M_Comandas;
use App\Models\M_Comandas_Platos;

class Comandas extends BaseController {

    public function subirComanda()
    {
        $mCom = new M_Comandas();

        $id_mesa = $this->request->getPost("id_mesa");
        $precio_total = $this->request->getPost("precio_total");
        $datos_platos = $this->request->getPost("datos_platos");
        
        $datos = [
            "id_mesa" => intval($id_mesa), 
            "fecha" => date("Y/m/d"), 
            "hora" => date("H:i:s"), 
            "precio_total" => $precio_total
        ];

        if ($id_comanda = $mCom->insertarRegistro($datos))
        {
            $mComPlatos = new M_Comandas_Platos();
            $correcto = true;

            foreach($datos_platos as $dato_plato)
            {

                $data = [
                    "id_comanda" => $id_comanda, 
                    "id_plato" => $dato_plato[0], 
                    "racion_plato" => $dato_plato[1], 
                    "n_unidades" => $dato_plato[2]
                ];

                if (!$mComPlatos->insertarRegistro($data))
                    $correcto = false;
            }

            if ($correcto)
                return json_encode(["data" => "Comanda con platos insertada con éxito"]);
        }
    }

}