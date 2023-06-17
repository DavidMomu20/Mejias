<?php 
namespace App\Controllers;

use CodeIgniter\Controller;

use App\Models\M_Comandas;
use App\Models\M_Comandas_Platos;
use App\Models\M_Platos;
use App\Models\M_Mesas;

class Comandas extends BaseController {

    /**
     * Mis variables de instancia
     */

    private array $rules = [
        'id_mesa' => 'required|numeric',
        'fecha' => 'required|valid_date',
        'hora' => 'required',
    ];

    public function subirComanda()
    {
        $mCom = new M_Comandas();

        $id_mesa = $this->request->getPost("id_mesa");
        $precio_total = $this->request->getPost("precio_total");
        $datos_platos = $this->request->getPost("datos_platos");
        
        $datos = [
            "id_mesa" => intval($id_mesa), 
            "fecha" => date("Y/m/d"), 
            "hora" => date("H:i:s"), 
            "precio_total" => $precio_total
        ];

        if ($id_comanda = $mCom->insertarRegistro($datos))
        {
            $mComPlatos = new M_Comandas_Platos();
            $correcto = true;

            foreach($datos_platos as $dato_plato)
            {

                $data = [
                    "id_comanda" => $id_comanda, 
                    "id_plato" => $dato_plato[0], 
                    "racion_plato" => $dato_plato[1], 
                    "n_unidades" => $dato_plato[2]
                ];

                if (!$mComPlatos->insertarRegistro($data))
                    $correcto = false;
            }

            if ($correcto)
                return json_encode(["data" => "Comanda con platos insertada con éxito"]);
        }
    }

    /**
     * =================== MÉTODOS CRUD =======================
     */

    /**
     * Método para acceder al crud
     */

    public function crud()
    {
        $mCom = new M_Comandas();
        $mMesas = new M_Mesas();

        $fecha = $this->request->getVar('fecha');
        $hora = $this->request->getVar('hora');
        $precio_total = $this->request->getVar("precio-total");
        $nRegistros = $this->request->getVar('n-registros');

        if (empty($nRegistros))
            $nRegistros = 5;

        $datos = [
            "fecha" => $fecha, 
            "hora" => $hora, 
            "precioTotal" => $precio_total
        ];

        $data["comandas"] = $mCom->dameComandas($datos)->paginate($nRegistros);
        $data["mesas"] = $mMesas->dameMesasDeHoy();
        $data["pager"] = $mCom->pager;
        $data["cuerpo"] = view("admin/cruds/comandas", $data);

        return view('template/admin', $data);
    }

    /**
     * Método CREAR
     */

    public function create()
    {
        $mCom = new M_Comandas();

        $id_mesa = $this->request->getPost("id_mesa");
        $fecha = $this->request->getVar('fecha');
        $hora = $this->request->getVar('hora');
        $precio_total = $this->request->getVar("precio_total");

        $reglas = $this->rules;
        $reglas["precio_total"] = "required|numeric";

        if (!$this->validate($reglas)) {
            
            $errors = $this->validator->getErrors();
            return json_encode($errors);
        }

        $data = [
            "id_mesa" => $id_mesa, 
            "fecha" => $fecha, 
            "hora" => $hora, 
            "precio_total" => $precio_total
        ];

        if ($newId = $mCom->insertarRegistro($data))
        {
            $data["id_comanda"] = $newId;
            return json_encode($data);
        }
    }

    /**
     * Método ACTUALIZAR
     */

    public function update()
    {
        $mCom = new M_Comandas();

        $id_comanda = $this->request->getPost("id_comanda");
        $id_mesa = $this->request->getPost("id_mesa");
        $fecha = $this->request->getPost("fecha");
        $hora = $this->request->getPost("hora");

        if (!$this->validate($this->rules)) {
            
            $errors = $this->validator->getErrors();
            return json_encode($errors);
        }

        $data = [
            "id_mesa" => $id_mesa, 
            "fecha" => $fecha, 
            "hora" => $hora, 
        ];

        if ($mCom->updateRegistro($id_comanda, $data))
        {
            $data["id_comanda"] = $id_comanda;
            return json_encode($data);
        }
    }

    /**
     * Método ELIMINAR
     */

    public function delete()
    {
        $mCom = new M_Comandas();

        $id_comanda = $this->request->getPost("id_comanda");

        if (!$mCom->eliminaPlatosComanda($id_comanda))
            return json_encode(["error" => "Error al eliminar la comanda"]);

        if ($mCom->deleteRegistro($id_comanda))
            return json_encode(["data" => "success"]);
    }
}