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
            "id_usuario" => $id_user,
            "id_estado" => 3,
            "fecha" => $fecha, 
            "hora" => $hora, 
            "n_comensales" => $n_comensales
        ];
        
        if ($id = $mRes->insertarRegistro($datos))
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

    public function dameMesasHoy()
    {
        $mRes = new M_Reservas_Mesa();
        return json_encode(["mesas" => $mRes->dameMesasDeHoy()]);
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

    public function rechazar()
    {
        $mRes = new M_Reservas_Mesa();

        $id = $this->request->getPost("id_reserva_mesa");
        $razon = $this->request->getPost("razon");

        $datos = [
            "id_estado" => 2
        ];

        if ($mRes->updateRegistro($id, $datos))
        {
            $email = $this->request->getPost("email");
            $usuario = $this->request->getPost("full_name");

            $datosMail = [
                "email" => $email, 
                "usuario" => $usuario, 
                "asunto" => "Reserva de Mesa Rechazada", 
                "body" => "Su reserva se ha rechazado. A continuación le mostramos los detalles: \n\n" . $razon
            ];

            return $this->enviarEmail($datosMail);
        }
    }

    /**
     * ==================== MÉTODOS CRUD ====================
     */

    /**
     * Acceder al crud
     */

    public function crud()
    {
        $mRes = new M_Reservas_Mesa();
        $mMesa = new M_Mesas();
        $mEst = new M_Estados();
        $mUser = new M_Usuarios();

        $data["reservas_mesa"] = $mRes->dameReservasMesa()->paginate(5);
        $data["pager"] = $mRes->pager;
        $data["mesas"] = $mMesa->obtenerRegistros([], ["id_mesa"])->findAll();
        $data["estados"] = $mEst->obtenerRegistros()->findAll();
        $data["usuarios"] = $mUser->obtenerRegistros([], ["id_usuario", "email"])->findAll();

        $data["cuerpo"] = view("admin/cruds/reservas-mesa", $data);

        return view('template/admin', $data);
    }
}