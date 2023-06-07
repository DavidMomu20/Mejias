<?php 
namespace App\Controllers;

use CodeIgniter\Controller;

use App\Models\M_Habitaciones;
use App\Models\M_Reservas_Habitacion;
use App\Models\M_Usuarios;

class ReservasHabitacion extends BaseController{

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

    public function realizar()
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

        $puntos = $this->request->getPost("puntos_usados");
        if (isset($puntos))
            $puntos = intval($puntos);

        $datos = [
            "id_habitacion" => $id_habitacion,
            "id_estado" => 3, 
            "fecha_inicio" => $fecha_inicio, 
            "fecha_fin" => $fecha_fin, 
            "n_huespedes" => $n_huespedes, 
            "puntos_usados" => $puntos
        ];

        if ($id = $mRes->insertReservaHab($datos, $id_user)) {

            $mUser = new M_Usuarios();
            $user = $mUser->obtenerRegistroByPrimaryKey($id_user);

            $dataUser = [
                "puntos" => $user["puntos"] - $puntos 
            ];

            if ($mUser->updateRegistro($id_user, $dataUser))
                echo json_encode(["data" => "Reserva de habitación Realizada con éxito"]);
        }
    }

    public function confirmar()
    {
        $mRes = new M_Reservas_Habitacion();

        $id = intval($this->request->getPost("id_reserva_hab"));

        $datos = [
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
                $mail->Subject = 'Su reserva de mesa se ha CONFIRMADO';
                $mail->Body = 'Se ha realizado la reserva de mesa con éxito. Su mesa será la nº' . $datos["id_mesa"] . ". ¡Le esperamos!";
                
                // Envía el correo electrónico
                $mail->send();

                echo json_encode(["data" => 'Correo enviado correctamente.']);
            } catch (Exception $e) {
                echo json_encode(["data" => 'Error al enviar el correo: ' . $mail->ErrorInfo]);
            }
        }
    }
}