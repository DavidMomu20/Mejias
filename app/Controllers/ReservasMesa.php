<?php 
namespace App\Controllers;

use CodeIgniter\Controller;

use App\Models\M_Reservas_Mesa;
use App\Models\M_Mesas;
use App\Libraries\TableLib;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Agrega esta línea

class ReservasMesa extends Controller{

    public function realizarReservaMesa()
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

    public function confirmarReservaMesa()
    {
        $mRes = new M_Reservas_Mesa();

        $id = intval($this->request->getPost("id_reserva_mesa"));

        $datos = [
            "id_mesa" => intval(filter_var($this->request->getPost("id_mesa"), FILTER_SANITIZE_NUMBER_INT)), 
            "id_estado" => 1
        ];

        if ($mRes->updateRegistro($id, $datos)) {

            // Crea una instancia de PHPMailer
            $mail = new PHPMailer(true);

            try {
                // Configuración del servidor de correo
                $mail->isSMTP();
                $mail->Host       = 'sandbox.smtp.mailtrap.io';  // Cambia por tu servidor SMTP
                $mail->SMTPAuth   = true;
                $mail->Username   = '08fd788cd37fcb';  // Cambia por tu dirección de correo
                $mail->Password   = '927b6721542ff2';  // Cambia por tu contraseña
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  // Opcionalmente cambia a ENCRYPTION_SMTPS para SMTPS
                $mail->Port       = 2525;  // Cambia por el puerto de tu servidor SMTP

                // Configuración del mensaje
                $mail->setFrom('davidmoralesm2003@hotmail.com', 'David Morales');
                $mail->addAddress('davidmomu4@gmail.com', 'David Morales');
                $mail->Subject = 'Correo de prueba';
                $mail->Body = 'Este es un correo de prueba enviado desde PHPMailer y Mailtrap.';
                
                // Envía el correo electrónico
                $mail->send();

                echo json_encode(["data" => 'Correo enviado correctamente.']);
            } catch (Exception $e) {
                echo json_encode(["data" => 'Error al enviar el correo: ' . $mail->ErrorInfo]);
            }
        }
    }

    /**
     * ==================== MÉTODOS CRUD ====================
     */

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