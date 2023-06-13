<?php 
namespace App\Controllers;

use CodeIgniter\Controller;

use App\Models\M_Habitaciones;
use App\Models\M_Reservas_Habitacion;
use App\Models\M_Usuarios;
use Dompdf\Dompdf;

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

        echo json_encode(["habitaciones" => $mHab->obtenerRegistros($where)->findAll()]);
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
            $user = $mUser->buscaUsuarioById($id_user);

            if ($mUser->restaPuntos($id_user, $puntos))
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

            $vistaPDF = view('pdfs/fianza');

            $dompdf = new Dompdf();
            $dompdf->loadHtml($vistaPDF);
            $dompdf->setPaper('A4', 'landscape');
            $dompdf->render();

            $pdfContent = $dompdf->output();

            $email = $this->request->getPost("email");
            $usuario = $this->request->getPost("full_name");

            $datosMail = [
                "email" => $email, 
                "usuario" => $usuario, 
                "asunto" => "Reserva de Habitación Confirmada", 
                "body" => "Su reserva se ha confirmado. Le adjuntamos un PDF con más especificaciones.", 
                "pdf" => $pdfContent
            ];

            return $this->enviarEmail($datosMail);
        }
    }

    public function rechazar()
    {
        $mRes = new M_Reservas_Habitacion();

        $id = $this->request->getPost("id_reserva_hab");

        $datos = [
            "id_estado" => 2
        ];

        if ($mRes->updateRegistro($id, $datos))
        {
            $razon = $this->request->getPost("razon");
            $email = $this->request->getPost("email");
            $usuario = $this->request->getPost("full_name");

            $datosMail = [
                "email" => $email, 
                "usuario" => $usuario, 
                "asunto" => "Reserva de Habitación Rechazada", 
                "body" => "Su reserva se ha rechazado. A continuación le mostramos los detalles: \n\n" . $razon
            ];

            return $this->enviarEmail($datosMail);
        }
    }
}