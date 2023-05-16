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

    public function mostrarMesas(?int $nc) {

        $mMesa = new Mesas();
        
        if ($mesas = $mMesa->dameMesasNComensales($nc))
            echo json_encode($mesas);
    }
}