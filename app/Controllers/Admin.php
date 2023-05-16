<?php 
namespace App\Controllers;

use CodeIgniter\Controller;

use App\Models\Reservas_Mesa;

class Admin extends Controller {

    public function index()
    {
        $data["cuerpo"] = view("admin/index");
        return view("template/admin", $data);
    }

    public function reservasMesaPendientes()
    {
        $mRes = new Reservas_Mesa();
        $reservas = $mRes->dameReservasMesaPendientes();

        $contador = (count($reservas) < 8 ? count($reservas) : 8);

        $data["reservas"] = $reservas;
        $data["contador"] = $contador;
        $data["cuerpo"] = view("admin/reservas", $data);

        return view("template/admin", $data);
    }

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