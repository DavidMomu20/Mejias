<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        echo view('mejias/index');
    }

    public function eligeReserva()
    {
        $data["titulo"] = "Elige Reserva";
        $data["cuerpo"] = view('mejias/eligeReserva');

        echo view('template/plantilla', $data);
    }
}
