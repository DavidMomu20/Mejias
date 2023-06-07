<?php 
namespace App\Controllers;

use CodeIgniter\Controller;

use App\Models\M_Reservas_Mesa;
use App\Models\M_Estados;
use App\Models\M_Mesas;
use App\Models\M_Usuarios;
use App\Libraries\TableLib;

class ReservasMesa extends BaseController {

    public function realizar()
    {
        $id_user = intval(session()->get('id_user'));
        $mRes = new M_Reservas_Mesa();

        $fecha = $this->request->getPost("fecha");
        if (isset($fecha))
            $fecha = date_create_from_format("Y-m-d", $fecha)->format("Y-m-d");

        $hora = $this->request->getPost("hora");
        if (isset($hora))
            $hora = date_create_from_format("H:i", $hora)->format("H:i:s");

        $n_comensales = $this->request->getPost("n_comensales");
        if (isset($n_comensales))
            $n_comensales = intval($n_comensales);

        $datos = [
            "id_estado" => 3,
            "fecha" => $fecha, 
            "hora" => $hora, 
            "n_comensales" => $n_comensales
        ];
        
        if ($id = $mRes->insertReservaMesa($datos, $id_user))
            echo json_encode(["data" => "success"]);
    }

    public function mostrarMesasDisponibles()
    {

        $mMesa = new M_Mesas();
        $mRes = new M_Reservas_Mesa();

        $nc = $this->request->getPost("n_comensales");
        $fecha = $this->request->getPost("fecha");

        if (($mesas = $mMesa->dameMesasNComensales($nc)) && ($reservas = $mRes->dameReservasMesaByFecha($fecha))) {
            $mesasDisponibles = $mesas;
            foreach ($mesas as $clave => $mesa) {
                foreach ($reservas as $reserva) {
                    if ($reserva["id_mesa"] == $mesa["id_mesa"]) {
                        array_splice($mesasDisponibles, $clave, 1);
                        break;
                    }
                }
            }

            echo json_encode($mesasDisponibles);
        }
    }

    public function confirmar()
    {
        $mRes = new M_Reservas_Mesa();

        $id = intval($this->request->getPost("id_reserva_mesa"));

        $datos = [
            "id_mesa" => intval(filter_var($this->request->getPost("id_mesa"), FILTER_SANITIZE_NUMBER_INT)), 
            "id_estado" => 1
        ];

        if ($mRes->updateRegistro($id, $datos)) {

            $email = $this->request->getPost("email");
            $usuario = $this->request->getPost("full_name");

            $datosMail = [
                "email" => $email, 
                "usuario" => $usuario, 
                "asunto" => "Reserva de Mesa Confirmada", 
                "body" => "Su reserva se ha confirmado. Le esperamos en la mesa " . $datos["id_mesa"] . ". ¡Le esperamos!"
            ];

            return $this->enviarEmail($datosMail);
        }
    }

    /**
     * ==================== MÉTODOS CRUD ====================
     */

     public function crud()
     {
         $mMesa = new M_Mesas();
         $mEst = new M_Estados();
         $mUser = new M_Usuarios();
 
         $data["mesas"] = $mMesa->obtenerRegistros([], ["id_mesa"]);
         $data["estados"] = $mEst->obtenerRegistros();
         $data["usuarios"] = $mUser->obtenerRegistros([], ["id_usuario", "email"]);
 
         $data["cuerpo"] = view("admin/cruds/reservas-mesa", $data);
 
         return view('template/admin', $data);
     }

    public function ajax()
    {
        $order = $this->request->getVar("order");
        $order = array_shift($order);

        $mRes = new M_Reservas_Mesa();
        $reservas = $mRes->dameReservasMesa();
        
        $columnas = ["id_reserva_mesa", "id_mesa", "estado", "email", "telefono", "fecha", "hora", "n_comensales"];
        $lib = new TableLib($reservas, 'gp1', $columnas);

        $response = $lib->getResponse([
            "draw" => $this->request->getVar("draw"), 
            "length" => $this->request->getVar("length"), 
            "start" => $this->request->getVar("start"), 
            "order" => $order["column"], 
            "direction" => $order["dir"]
        ]);

        echo json_encode($response);
    }
}