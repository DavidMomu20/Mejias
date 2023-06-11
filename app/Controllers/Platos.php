<?php 
namespace App\Controllers;

use CodeIgniter\Controller;

use App\Models\M_Platos;
use App\Models\M_Alergenos;

class Platos extends BaseController {

    public function verCarta(?int $id_cat = null)
    {
        $mPlatos = new M_Platos();
        $mAl = new M_Alergenos();

        $platos = $mPlatos->obtenerRegistros(["id_categoria" => $id_cat])->findAll();

        foreach ($platos as $cont => $plato)
            $platos[$cont]["alergenos"] = $mAl->dameAlergenosPlato($platos[$cont]["id_plato"]);

        $data["platos"] = $platos;
        $data["titulo"] = "Carta";
        $data["cuerpo"] = view("mejias/carta", $data);

        return view('template/plantilla', $data);
    }

    public function platosPorCategoria()
    {
        $mPlatos = new M_Platos();
        $id_cat = $this->request->getPost("id");

        return json_encode(["platos" => $mPlatos->obtenerRegistros(["id_categoria" => $id_cat])->findAll()]);
    }

}