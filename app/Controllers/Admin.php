<?php 
namespace App\Controllers;

use CodeIgniter\Controller;

use App\Models\M_Reservas_Mesa;
use App\Models\M_Reservas_Habitacion;
use App\Models\M_Platos;
use App\Models\M_Categorias;
use App\Models\M_Mesas;
use App\Models\M_Estados;
use App\Models\M_Usuarios;

class Admin extends Controller {

    public function index()
    {
        if (session()->get('logged_in')) {

            if (session()->get("permisos_user")["perm10"] == 1)
                return redirect()->to(base_url("admin/crud/reservas-mesa"));

            if (session()->get("permisos_user")["perm9"] == 1)
                return redirect()->to(base_url("admin/reservas-mesa-pendientes"));

            if (session()->get("permisos_user")["perm8"] == 1)
                return redirect()->to(base_url('admin/comandas'));
        }
        else
            return redirect()->to(base_url());
    }

    /**
     * ---------- Funciones para administrar las reservas PENDIENTES ----------
     */

    public function reservasMesaPendientes()
    {
        $mRes = new M_Reservas_Mesa();
        $reservas = $mRes->dameReservasMesaPendientes();

        $contador = (count($reservas) < 8 ? count($reservas) : 8);

        $data["reservas"] = $reservas;
        $data["contador"] = $contador;
        $data["cuerpo"] = view("admin/mesas/pendientes", $data);

        return view("template/admin", $data);
    }

    public function reservasHabPendientes()
    {
        $mRes = new M_Reservas_Habitacion();
        $reservas = $mRes->dameReservasHabPendientes();

        $contador = count($reservas);

        $data["reservas"] = $reservas;
        $data["contador"] = $contador;
        $data["cuerpo"] = view("admin/habitaciones/pendientes", $data);

        return view("template/admin", $data);
    }

    /**
     * ---------- Método para abrir la gestión de comandas ----------
     */

    public function comandas()
    {
        $mPlatos = new M_Platos();

        $platos = $mPlatos->obtenerRegistros([], ["*"], "id_categoria");

        $data["platos"] = [
            "bocadillos" => array_filter($platos, function ($plato) { return $plato["id_categoria"] == "1"; }), 
            "platos_combinados" => array_filter($platos, function ($plato) { return $plato["id_categoria"] == "2"; }), 
            "raciones_frias" => array_filter($platos, function ($plato) { return $plato["id_categoria"] == "3"; }), 
            "bebidas" => array_filter($platos, function ($plato) { return $plato["id_categoria"] == "8"; }), 
        ];
        $data["cuerpo"] = view("admin/comandas/comandas", $data);

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

    /**
     * ---------- MÉTODOS CRUD ----------
     */

    public function crudReservasMesa()
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
}