<?php 
namespace App\Controllers;

use CodeIgniter\Controller;

use App\Models\M_Reservas_Mesa;
use App\Models\M_Estados;
use App\Models\M_Mesas;
use App\Models\M_Usuarios;
use App\Libraries\TableLib;

class ReservasMesa extends BaseController {

    /**
     * Mis variables de instancia
     */

    private array $rules = [
        'id_mesa' => 'permit_empty|numeric',
        'id_estado' => 'required|numeric',
        'id_usuario' => 'required|numeric',
        'fecha' => 'required',
        'hora' => 'required',
        'n_comensales' => 'required|numeric'
    ];

    /**
     * Método para crear una nueva reserva por parte del cliente.
     */

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

    /**
     * Método para mostrar todas las mesas disponibles para la fecha en la que
     * se ha establecido la reserva y el nº de comensales establecido en esta.
     */
    
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

    /**
     * Método para obtener las mesas de hoy
     */

    public function dameMesasHoy()
    {
        $mMesas = new M_Mesas();
        return json_encode(["mesas" => $mMesas->dameMesasDeHoy()]);
    }

    /**
     * Método para confirmar una reserva. Se manda un email al cliente con 
     * la confirmación.
     */
    
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
     * Método para rechazar una reserva. Se le manda un email al cliente con
     * el motivo por el cual se rechaza la reserva.
     */

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

        $fecha = $this->request->getVar('fecha');
        $estado = $this->request->getVar('estados');
        $nComensales = $this->request->getVar('n_comensales');
        $usuario = $this->request->getVar('usuarios');
        $nRegistros = $this->request->getVar('n-registros');

        if (empty($nRegistros))
            $nRegistros = 5;

        $datos = [
            "fecha" => $fecha, 
            "estado" => $estado, 
            "nComensales" => $nComensales, 
            "usuario" => $usuario
        ];

        $data["reservas_mesa"] = $mRes->dameReservasMesa($datos)->paginate($nRegistros);
        $data["pager"] = $mRes->pager;
        $data["mesas"] = $mMesa->obtenerRegistros([], ["id_mesa"])->findAll();
        $data["estados"] = $mEst->obtenerRegistros()->findAll();
        $data["usuarios"] = $mUser->obtenerRegistros(["id_rol" => 12], ["id_usuario", "email"])->findAll();

        $data["cuerpo"] = view("admin/cruds/reservas-mesa", $data);

        return view('template/admin', $data);
    }

    /**
     * Método CREAR
     */

    public function create()
    {
        $mRes = new M_Reservas_Mesa();

        $id_mesa = $this->request->getPost("id_mesa");
        $id_estado = $this->request->getPost("id_estado");
        $id_usuario = $this->request->getPost("id_usuario");
        $fecha = $this->request->getPost("fecha");
        $hora = $this->request->getPost("hora");
        $n_comensales = $this->request->getPost("n_comensales");

        if (empty($id_mesa))
            $id_mesa = null;

        if (!$this->validate($this->rules)) {
            // La validación falló, devuelvo los mensajes de error
            $errors = $this->validator->getErrors();
            return json_encode(['error' => $errors]);
        }

        $data = [
            "id_mesa" => $id_mesa, 
            "id_estado" => $id_estado, 
            "id_usuario" => $id_usuario, 
            "fecha" => $fecha, 
            "hora" => $hora, 
            "n_comensales" => $n_comensales
        ];

        if ($newId = $mRes->insertarRegistro($data))
        {
            $mUser = new M_Usuarios();
            $mEstados = new M_Estados();

            $data["id_reserva_mesa"] = $newId;
            $data["email"] = $mUser->obtenerRegistros(["id_usuario" => $data["id_usuario"]])["email"];
            $data["estado"] = $mEstados->obtenerRegistros(["id_estado" => $data["id_estado"]])["descripcion"];
            return json_encode($data);
        }
    }

    /**
     * Método ACTUALIZAR
     */

    public function update()
    {
        $mRes = new M_Reservas_Mesa();

        $id_reserva_mesa = $this->request->getPost("id_reserva_mesa");
        $id_mesa = $this->request->getPost("id_mesa");
        $id_estado = $this->request->getPost("id_estado");
        $id_usuario = $this->request->getPost("id_usuario");
        $fecha = $this->request->getPost("fecha");
        $hora = $this->request->getPost("hora");
        $n_comensales = $this->request->getPost("n_comensales");

        if (empty($id_mesa))
            $id_mesa = null;

        if (!$this->validate($this->rules)) {
            // La validación falló, devuelvo los mensajes de error
            $errors = $this->validator->getErrors();
            return json_encode(['error' => $errors]);
        }

        $data = [
            "id_mesa" => $id_mesa, 
            "id_estado" => $id_estado, 
            "id_usuario" => $id_usuario, 
            "fecha" => $fecha, 
            "hora" => $hora, 
            "n_comensales" => $n_comensales
        ];

        if ($mRes->updateRegistro($id_reserva_mesa, $data))
        {
            $mUser = new M_Usuarios();
            $mEstados = new M_Estados();

            $data["email"] = $mUser->obtenerRegistros(["id_usuario" => $data["id_usuario"]])["email"];
            $data["estado"] = $mEstados->obtenerRegistros(["id_estado" => $data["id_estado"]])["descripcion"];
            return json_encode($data);
        }
    }

    /**
     * Método ELIMINAR
     */

    public function delete()
    {
        $mRes = new M_Reservas_Mesa();

        $id_reserva_mesa = $this->request->getPost("id_reserva_mesa");

        if ($mRes->deleteRegistro($id_reserva_mesa))
            return json_encode(["data" => "success"]);
    }
}