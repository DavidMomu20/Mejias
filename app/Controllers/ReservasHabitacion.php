<?php 
namespace App\Controllers;

use CodeIgniter\Controller;

use App\Models\M_Habitaciones;
use App\Models\M_Reservas_Habitacion;

class ReservasHabitacion extends Controller{

    public function buscarHabitaciones()
    {
        $mHab = new M_Habitaciones();

        $where = [];

        $capacidad = $this->request->getPost("capacidad");
        if (isset($capacidad)) {
            if ($capacidad != "")
                $where["capacidad"] = intval($capacidad);
        }

        $precio = $this->request->getPost("precio");
        if (isset($precio)) {
            if ($precio != "")
                $where["precio"] = floatval($precio);
        }

        echo json_encode(["habitaciones" => $mHab->obtenerRegistros($where)]);
    }

    public function realizarReservaHab()
    {
        $mRes = new M_Reservas_Habitacion();
        $id_user = intval(session()->get('id_user'));

        $fecha_inicio = $this->request->getPost("fecha_inicio");
        if (isset($fecha_inicio))
            $fecha_inicio = date_create_from_format("Y-m-d", $fecha_inicio)->format("Y-m-d");

        $fecha_fin = $this->request->getPost("fecha_fin");
        if (isset($fecha_fin))
            $fecha_fin = date_create_from_format("Y-m-d", $fecha_fin)->format("Y-m-d");

        $n_huespedes = $this->request->getPost("n_huespedes");
        if (isset($n_huespedes))
            $n_huespedes = intval($n_huespedes);

        $id_habitacion = $this->request->getPost("id_habitacion");
        if (isset($id_habitacion))
            $id_habitacion = intval($id_habitacion);

        $datos = [
            "id_habitacion" => $id_habitacion,
            "id_estado" => 3, 
            "fecha_inicio" => $fecha_inicio, 
            "fecha_fin" => $fecha_fin, 
            "n_huespedes" => $n_huespedes
        ];

        if ($id = $mRes->insertReservaHab($datos, $id_user))
            echo json_encode(["data" => "Reserva de habitación Realizada con éxito"]);
    }
}