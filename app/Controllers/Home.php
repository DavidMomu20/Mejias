<?php

namespace App\Controllers;

use App\Models\Habitaciones;

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

    public function verHabitaciones()
    {
        $mHab = new Habitaciones();
        
        $data["habitaciones"] = $mHab->obtenerRegistros();
        $data["titulo"] = "Ver Habitaciones";
        $data["cuerpo"] = view('mejias/habitaciones', $data);
        return view('template/plantilla', $data);
    }
}
