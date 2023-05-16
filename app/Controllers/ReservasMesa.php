<?php 
namespace App\Controllers;

use CodeIgniter\Controller;

use App\Models\Reservas_Mesa;
use App\Models\Mesas;

class ReservasMesa extends Controller{

    public function index(?string $tipo = null)
    {
        $data["tipo"] = $tipo;
        $data["titulo"] = "Reserva de " . $tipo;
        $data["cuerpo"] = view('mejias/reserva', $data);
        return view('template/plantilla', $data);
    }

    public function reservarMesa()
    {
        $id_user = intval(session()->get('id_user'));
        $mRes = new Reservas_Mesa();

        if (isset($_POST["fecha"]))
            $fecha = date_create_from_format("Y-m-d", $_POST["fecha"])->format("Y-m-d");

        if (isset($_POST["hora"]))
            $hora = date_create_from_format("H:i", $_POST["hora"])->format("H:i:s");

        if (isset($_POST["n_comensales"]))
            $n_comensales = intval($_POST["n_comensales"]);

        $datos = [
            "id_estado" => 6,
            "fecha" => $fecha, 
            "hora" => $hora, 
            "n_comensales" => $n_comensales, 
            "mesa_asignada" => null
        ];
        
        if ($id = $mRes->insertReservaMesa($datos, $id_user))
            echo json_encode(["data" => "success"]);
    }

    public function mostrarMesasDisponibles() {

        $mMesa = new Mesas();
        $mRes = new Reservas_Mesa();

        $nc = $_POST["n_comensales"];
        $fecha = $_POST["fecha"];
        
        if (($mesas = $mMesa->dameMesasNComensales($nc)) && ($reservas = $mRes->dameReservasMesaByFecha($fecha))) {
            
            foreach ($mesas as $clave => $mesa) {
                foreach ($reservas as $reserva) {
                    if ($reserva["id_mesa"] == $mesa["id_mesa"]) {
                        array_splice($mesas, $clave, 1);
                        break;
                    }
                }
            }

            echo json_encode($mesas);
        }
    }

    public function confirmarReservaMesa(?int $id = null)
    {
        $mRes = new Reservas_Mesa();

        $datos = [
            "id_reserva_mesa" => $id, 
            "id_mesa" => $_POST["id_mesa"], 
            "id_estado" => 4
        ];

        if ($mRes->updateReservaMesa($id, $datos)) {
            echo json_encode(["data" => "Reserva confirmada correctamente"])
        }
    }
}