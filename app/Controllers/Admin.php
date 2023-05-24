<?php 
namespace App\Controllers;

use CodeIgniter\Controller;

use App\Models\Reservas_Mesa;
use App\Models\Reservas_Habitacion;

class Admin extends Controller {

    public function index()
    {
        $data["cuerpo"] = view("admin/index");
        return view("template/admin", $data);
    }

    /**
     * ---------- Funciones para administrar las reservas PENDIENTES ----------
     */

    public function reservasMesaPendientes()
    {
        $mRes = new Reservas_Mesa();
        $reservas = $mRes->dameReservasMesaPendientes();

        $contador = (count($reservas) < 8 ? count($reservas) : 8);

        $data["reservas"] = $reservas;
        $data["contador"] = $contador;
        $data["cuerpo"] = view("admin/mesas/pendientes", $data);

        return view("template/admin", $data);
    }

    public function reservasHabPendientes()
    {
        $mRes = new Reservas_Habitacion();
        $reservas = $mRes->dameReservasHabPendientes();

        $contador = count($reservas);

        $data["reservas"] = $reservas;
        $data["contador"] = $contador;
        $data["cuerpo"] = view("admin/habitaciones/pendientes", $data);

        return view("template/admin", $data);
    }

    /**
     * ---------- Método para enviar emails ----------
     */

    public function enviarEmail()
    {
        $this->email = \Config\Services::email();

        try {
            $this->email->setFrom('davidmoralesm2003@gmail.com', 'David Morales - Hostal Restaurante Mejías');
            $this->email->setTo('davidmomu4@gmail.com');
            $this->email->setSubject('Asunto del Correo');
            $this->email->setMessage('Cuerpo del correo electrónico');
            
            $this->email->send();
            
            echo json_encode(["data" => "success"]);
        } catch (\Exception $e) {
            echo "Error al enviar el correo: " . $e->getMessage();
        }
    }

}