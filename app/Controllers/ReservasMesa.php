<?php 
namespace App\Controllers;

use CodeIgniter\Controller;

use App\Models\Reservas_Mesa;
use App\Models\Mesas;

class ReservasMesa extends Controller{

    public function realizarReservaMesa()
    {
        $id_user = intval(session()->get('id_user'));
        $mRes = new Reservas_Mesa();

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

        $mMesa = new Mesas();
        $mRes = new Reservas_Mesa();

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

    public function confirmarReservaMesa()
    {
        $mRes = new Reservas_Mesa();

        $id = intval($this->request->getPost("id_reserva_mesa"));

        $datos = [
            "id_mesa" => intval(filter_var($this->request->getPost("id_mesa"), FILTER_SANITIZE_NUMBER_INT)), 
            "id_estado" => 1
        ];

        // Filtrar y sanitizar los datos
        /*
        $datosFiltrados = [
            'id_mesa' => filter_var($datos['id_mesa'], FILTER_SANITIZE_NUMBER_INT),
            'id_estado' => filter_var($datos['id_estado'], FILTER_SANITIZE_NUMBER_INT),
        ];
        */

        if ($mRes->updateRegistro($id, $datos)) {

            $email = new \App\Libraries\EmailsSender();

            # Pasamos los parámetros del envío
            $datosEmail['emailTO'] = "davidmomu4@gmail.com";
            $datosEmail['subject'] = "Esto es un email de prueba";
            $datosEmail['message'] = "Y esto es un texto de pruebas";

            if ($email->SendEmails($datosEmail))
                echo json_encode(["data" => "Reserva Confirmada con éxito - Email enviado con éxito"]);
            else
                echo json_encode(["data" => "Reserva Confirmada con éxito - Email enviado sin éxito"]);
        }
        else
            echo json_encode(["data" => "Reserva Confirmada sin éxito"]);
    }
}