<?php

namespace App\Controllers;

use App\Models\M_Habitaciones;

class Home extends BaseController
{
    public function index()
    {
        echo view('mejias/index');
    }

    public function reservarMesa()
    {
        $data["titulo"] = "Reserva de mesa";
        $data["cuerpo"] = view('mejias/reservamesa', $data);
        return view('template/plantilla', $data);
    }

    public function reservarHab(?int $id = null)
    {
        $data["titulo"] = "Reserva de habitación";
        $data["id"] = $id;
        $data["cuerpo"] = view('mejias/reservahabitacion', $data);
        return view('template/plantilla', $data);
    }

    public function verHabitaciones()
    {
        $mHab = new M_Habitaciones();
        
        $data["habitaciones"] = $mHab->obtenerRegistros();
        $data["titulo"] = "Ver Habitaciones";
        $data["cuerpo"] = view('mejias/habitaciones', $data);
        return view('template/plantilla', $data);
    }
}
