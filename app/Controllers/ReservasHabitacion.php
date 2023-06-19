<?php 
namespace App\Controllers;

use CodeIgniter\Controller;

use App\Models\M_Reservas_Habitacion;
use App\Models\M_Habitaciones;
use App\Models\M_Estados;
use App\Models\M_Usuarios;
use Dompdf\Dompdf;

class ReservasHabitacion extends BaseController{

    /**
     * Mis variables de instancia
     */

    private array $rules = [
        'id_habitacion' => 'required|numeric',
        'id_estado' => 'required|numeric',
        'id_usuario' => 'required|numeric',
        'fecha_inicio' => 'required|valid_date[Y-m-d]',
        'fecha_fin' => 'required|valid_date[Y-m-d]',
        'n_huespedes' => 'required|numeric',
        'puntos_usados' => 'required|numeric'
    ];

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
            "id_usuario" => $id_user,
            "id_habitacion" => $id_habitacion,
            "id_estado" => 3, 
            "fecha_inicio" => $fecha_inicio, 
            "fecha_fin" => $fecha_fin, 
            "n_huespedes" => $n_huespedes, 
            "puntos_usados" => $puntos
        ];

        if ($id = $mRes->insertarRegistro($datos)) {

            session()->setFlashData('reserva', "Su reserva de habitación se ha realizado correctamente. Le enviaremos un correo con la confirmación o rechazo de esta.");

            $mUser = new M_Usuarios();
            $user = $mUser->buscaUsuarioById($id_user);

            if ($mUser->restaPuntos($id_user, $puntos))
                echo json_encode(["data" => base_url()]);
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

    /**
     * ==================== MÉTODOS CRUD ====================
     */

    public function crud()
    {
        $mRes = new M_Reservas_Habitacion();
        $mHab = new M_Habitaciones();
        $mEst = new M_Estados();
        $mUser = new M_Usuarios();

        $fecha_inicio = $this->request->getVar('fecha-inicio');
        $estado = $this->request->getVar('estados');
        $nHuespedes = $this->request->getVar('n_huespedes');
        $fecha_fin = $this->request->getVar('fecha-fin');
        $usuario = $this->request->getVar('usuarios');
        $nRegistros = $this->request->getVar('n-registros');

        if (empty($nRegistros))
            $nRegistros = 5;

        $datos = [
            "fechaInicio" => $fecha_inicio, 
            "estado" => $estado, 
            "nHuespedes" => $nHuespedes, 
            "usuario" => $usuario, 
            "fechaFin" => $fecha_fin
        ];

        $data["reservas_hab"] = $mRes->dameReservasHab($datos)->paginate($nRegistros);
        $data["pager"] = $mRes->pager;
        $data["habitaciones"] = $mHab->obtenerRegistros([], ["id_habitacion", "num_habitacion"])->findAll();
        $data["estados"] = $mEst->obtenerRegistros()->findAll();
        $data["usuarios"] = $mUser->obtenerRegistros(["id_rol" => 12], ["id_usuario", "email"])->findAll();
        $data["cuerpo"] = view("admin/cruds/reservas-hab", $data);

        return view('template/admin', $data);
    }

    /**
     * Método CREAR
     */

    public function create()
    {
        $mRes = new M_Reservas_Habitacion();
        $mUser = new M_Usuarios();
        $mHab = new M_Habitaciones();
        $mEstados = new M_Estados();

        $id_habitacion = $this->request->getPost("id_habitacion");
        $id_estado = $this->request->getPost("id_estado");
        $id_usuario = $this->request->getPost("id_usuario");
        $fecha_inicio = $this->request->getPost("fecha_inicio");
        $fecha_fin = $this->request->getPost("fecha_fin");
        $n_huespedes = $this->request->getPost("n_huespedes");
        $puntos_usados = $this->request->getPost("puntos_usados");

        if (!$this->validate($this->rules)) {
            // La validación falló, devuelvo los mensajes de error
            $errors = $this->validator->getErrors();
            return json_encode(['error' => $errors]);
        }

        // Comprobar si fecha de salida es posterior a fecha de entrada
        if (strtotime($fecha_fin) < strtotime($fecha_inicio))
            return json_encode(['error' => 'La fecha de salida no puede ser anterior a la fecha de entrada']);

        // Resto los puntos al usuario seleccionado
        if (!$mUser->restaPuntos($id_usuario, $puntos_usados))
            return json_encode(['error' => 'Error al restar puntos al usuario']);

        $data = [
            "id_habitacion" => $id_habitacion, 
            "id_estado" => $id_estado, 
            "id_usuario" => $id_usuario, 
            "fecha_inicio" => $fecha_inicio, 
            "fecha_fin" => $fecha_fin,
            "n_huespedes" => $n_huespedes,  
            "puntos_usados" => $puntos_usados
        ];

        if ($newId = $mRes->insertarRegistro($data))
        {
            $data["id_reserva_hab"] = $newId;
            $data["num_habitacion"] = $mHab->obtenerRegistros(["id_habitacion" => $id_habitacion])["num_habitacion"];
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
        $mRes = new M_Reservas_Habitacion();
        $mUser = new M_Usuarios();

        $id_reserva_hab = $this->request->getPost("id_reserva_hab");
        $id_habitacion = $this->request->getPost("id_habitacion");
        $id_estado = $this->request->getPost("id_estado");
        $id_usuario = $this->request->getPost("id_usuario");
        $fecha_inicio = $this->request->getPost("fecha_inicio");
        $fecha_fin = $this->request->getPost("fecha_fin");
        $n_huespedes = $this->request->getPost("n_huespedes");
        $puntos_usados = $this->request->getPost("puntos_usados");
        $puntos_anteriores = $this->request->getPost("puntos_anteriores");

        // Si los puntos se han cambiado, convendría devolverselos o quitarselos
        // usuario afectado

        $usuario = $mUser->buscaUsuarioById($id_usuario);
        $diferencia = abs($puntos_usados - $puntos_anteriores);

        $this->cambiaPuntos($mUser, $usuario, $diferencia, $puntos_anteriores, $puntos_usados);

        if (!$this->validate($this->rules)) {
            // La validación falló, devuelvo los mensajes de error
            $errors = $this->validator->getErrors();
            return json_encode(['error' => $errors]);
        }

        // Comprobar si fecha de salida es posterior a fecha de entrada
        if (strtotime($fecha_fin) < strtotime($fecha_inicio))
            return json_encode(['error' => 'La fecha de salida no puede ser anterior a la fecha de entrada']);

        $data = [
            "id_habitacion" => $id_habitacion, 
            "id_estado" => $id_estado, 
            "id_usuario" => $id_usuario, 
            "fecha_inicio" => $fecha_inicio, 
            "fecha_fin" => $fecha_fin,
            "n_huespedes" => $n_huespedes,  
            "puntos_usados" => $puntos_usados
        ];

        if ($mRes->updateRegistro($id_reserva_hab, $data))
        {
            $mHab = new M_Habitaciones();
            $mEstados = new M_Estados();

            $data["num_habitacion"] = $mHab->obtenerRegistros(["id_habitacion" => $id_habitacion])["num_habitacion"];
            $data["email"] = $mUser->obtenerRegistros(["id_usuario" => $id_usuario])["email"];
            $data["estado"] = $mEstados->obtenerRegistros(["id_estado" => $data["id_estado"]])["descripcion"];
            return json_encode($data);
        }
    }

    /**
     * Método ELIMINAR
     */

    public function delete()
    {
        $mRes = new M_Reservas_Habitacion();
        $mUser = new M_Usuarios();

        $id_reserva_hab = $this->request->getPost("id_reserva_hab");
        $id_usuario = $this->request->getPost("id_usuario");
        $puntos = $this->request->getPost("puntos");

        $usuario = $mUser->buscaUsuarioById($id_usuario);
        $datosUser = [
            "puntos" => $usuario["puntos"] + intval($puntos)
        ];

        if ($mUser->updateRegistro($id_usuario, $datosUser))
        {
            if ($mRes->deleteRegistro($id_reserva_hab))
                return json_encode(["data" => "success"]);
        }
    }

    /**
     * Función privada para cambiar los puntos del usuario
     */

    private function cambiaPuntos($modelo, $usuario, int $diferencia, int $puntos_anteriores, int $puntos_usados)
    {
        if ($diferencia != 0) {

            if ($puntos_anteriores < $puntos_usados)
                $nuevos_puntos = $usuario["puntos"] - $diferencia;

            else
                $nuevos_puntos = $usuario["puntos"] + $diferencia;
        
            if ($nuevos_puntos >= 0) {
                $data = [
                    "puntos" => $nuevos_puntos
                ];
        
                if (!$modelo->updateRegistro($usuario["id_usuario"], $data)) {
                    return json_encode(["error" => "Puntos mal introducidos"]);
                }
            }
            else
                return json_encode(["error" => "El valor de puntos no puede ser 0 o negativo"]);
        }
    }
}