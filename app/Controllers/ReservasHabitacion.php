<?php 
namespace App\Controllers;

use CodeIgniter\Controller;

use App\Models\Habitaciones;

class ReservasHabitacion extends Controller{

    public function buscarHabitaciones()
    {
        $mHab = new Habitaciones();

        $where = [];

        if (isset($this->request->getPost("capacidad"))) {
            $capacidad = $this->request->getPost("capacidad");
            if ($capacidad != "")
                $where["capacidad"] = intval($capacidad);
        }

        if (isset($this->request->getPost("precio"))) {
            $precio = $this->request->getPost("precio");
            if ($precio != "")
                $where["precio"] = floatval($precio);
        }

        echo json_encode(["habitaciones" => $mHab->obtenerRegistros($where)]);
    }

    public function realizarReservaHab()
    {
        $mRes = new Reservas_Habitacion();
        $id_user = intval(session()->get('id_user'));

        if (isset($this->request->getPost("fecha_inicio")))
            $fecha_inicio = date_create_from_format("Y-m-d", $this->request->getPost("fecha_inicio"))->format("Y-m-d");

        if (isset($this->request->getPost("fecha_fin")))
            $fecha_fin = date_create_from_format("Y-m-d", $this->request->getPost("fecha_fin"))->format("Y-m-d");

        if (isset($this->request->getPost("n_huespedes")))
            $n_huespedes = intval($this->request->getPost("n_huespedes"));

        if (isset($this->request->getPost("id_habitacion")))
            $id_habitacion = intval($this->request->getPost("id_habitacion"));

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