<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        echo view('mejias/index');
    }

    public function reservaElegida(?string $tipo = null)
    {
        $data["tipo"] = $tipo;
        $data["titulo"] = "Reserva de " . $tipo;
        $data["cuerpo"] = view('mejias/reserva' . $tipo, $data);
        return view('template/plantilla', $data);
    }
}
