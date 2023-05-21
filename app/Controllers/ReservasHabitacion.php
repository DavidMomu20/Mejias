<?php 
namespace App\Controllers;

use CodeIgniter\Controller;

use App\Models\Habitaciones;

class ReservasHabitacion extends Controller{

    public function index(?string $tipo = null)
    {
        $data["tipo"] = $tipo;
        $data["titulo"] = "Reserva de " . $tipo;
        $data["cuerpo"] = view('mejias/reserva', $data);
        return view('template/plantilla', $data);
    }

    public function buscarHabitaciones()
    {
        $mHab = new Habitaciones();

        $where = [];

        if (isset($_POST["capacidad"])) {
            $capacidad = $_POST["capacidad"];
            if ($capacidad != "")
                $where["capacidad"] = intval($capacidad);
        }

        if (isset($_POST["precio"])) {
            $precio = $_POST["precio"];
            if ($precio != "")
                $where["precio"] = floatval($precio);
        }

        echo json_encode(["habitaciones" => $mHab->obtenerRegistros($where)]);
    }

}