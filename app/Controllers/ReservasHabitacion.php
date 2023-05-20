<?php 
namespace App\Controllers;

use CodeIgniter\Controller;

class ReservasHabitacion extends Controller{

    public function index(?string $tipo = null)
    {
        $data["tipo"] = $tipo;
        $data["titulo"] = "Reserva de " . $tipo;
        $data["cuerpo"] = view('mejias/reserva', $data);
        return view('template/plantilla', $data);
    }

}