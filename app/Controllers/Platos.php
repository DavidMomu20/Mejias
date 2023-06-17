<?php 
namespace App\Controllers;

use CodeIgniter\Controller;

use App\Models\M_Platos;
use App\Models\M_Categorias;
use App\Models\M_Alergenos;

class Platos extends BaseController {

    /**
     * Mis variables de instancia
     */

    private array $rules = [
        "id_categoria" => "required|numeric", 
        "nombre" => "required", 
        "precio_entera" => "required|numeric", 
        "precio_mitad" => "permit_empty|numeric", 
        "imagen" => [
            "permit_empty",
            "uploaded[imagen]", 
            "mime_in[imagen,image/jpg,image/jpeg,image/png]", 
            "max_size[imagen,1024]"
        ]
    ];

    public function verCarta(?int $id_cat = null)
    {
        $mPlatos = new M_Platos();
        $mAl = new M_Alergenos();

        $platos = $mPlatos->obtenerRegistros(["id_categoria" => $id_cat])->findAll();

        foreach ($platos as $cont => $plato)
            $platos[$cont]["alergenos"] = $mAl->dameAlergenosPlato($platos[$cont]["id_plato"]);

        $data["platos"] = $platos;
        $data["titulo"] = "Carta";
        $data["cuerpo"] = view("mejias/carta", $data);

        return view('template/plantilla', $data);
    }

    public function platosPorCategoria()
    {
        $mPlatos = new M_Platos();
        $id_cat = $this->request->getPost("id");

        return json_encode(["platos" => $mPlatos->obtenerRegistros(["id_categoria" => $id_cat])->findAll()]);
    }

    /**
     * ====================== MÉTODOS CRUD ======================
     */

    /**
     * Método para acceder al crud
     */

    public function crud()
    {
        $mPlatos = new M_Platos();
        $mCat = new M_Categorias();

        $id_categoria = $this->request->getVar("categorias");
        $precio_entera = $this->request->getVar("precio-entera");
        $nRegistros = $this->request->getVar('n-registros');

        if (empty($nRegistros))
            $nRegistros = 5;

        $datos = [
            "id_categoria" => $id_categoria, 
            "precio_entera" => $precio_entera, 
        ];

        $data["platos"] = $mPlatos->damePlatos($datos)->paginate($nRegistros);
        $data["categorias"] = $mCat->obtenerRegistros()->findAll();
        $data["pager"] = $mPlatos->pager;
        $data["cuerpo"] = view("admin/cruds/platos", $data);

        return view('template/admin', $data);
    }

    /**
     * Método CREAR
     */

    public function create()
    {
        $mPlatos = new M_Platos();
        $mCat = new M_Categorias();

        $id_categoria = $this->request->getPost("id_categoria");
        $nombre = $this->request->getPost("nombre");
        $precio_entera = $this->request->getPost("precio_entera");
        $precio_media = $this->request->getPost("precio_media");

        if ($precio_media <= 0 || empty($precio_media))
            $precio_media = null;

        if (!$this->validate($this->rules)) {
        
            $errors = $this->validator->getErrors();
            return json_encode($errors);
        }

        $data = [
            "id_categoria" => $id_categoria,
            "nombre" => $nombre,
            "precio_entera" => $precio_entera, 
            "precio_media" => $precio_media
        ];

        if ($imagen = $this->request->getFile("imagen")) {

            $nombreImagen = $imagen->getName();
            $imagen->move(APPPATH . '../assets/img/platos', $nombreImagen);

            $data["imagen"] = $nombreImagen;
        }
        else
            $data["imagen"] = "sin-imagen.png";

        if ($newId = $mPlatos->insertarRegistro($data))
        {
            $data["id_plato"] = $newId;
            $data["categoria"] = $mCat->obtenerRegistros(["id_categoria" => $id_categoria])["descripcion"];
            return json_encode($data);
        }
    }

    /**
     * Método ACTUALIZAR
     */

    public function update()
    {
        $mPlatos = new M_Platos();
        $mCat = new M_Categorias();

        $id_plato = $this->request->getPost("id_plato");
        $id_categoria = $this->request->getPost("id_categoria");
        $nombre = $this->request->getPost("nombre");
        $precio_entera = $this->request->getPost("precio_entera");
        $precio_media = $this->request->getPost("precio_media");

        if ($precio_media <= 0 || empty($precio_media))
            $precio_media = null;


        if (!$this->validate($this->rules)) {
            
            $errors = $this->validator->getErrors();
            return json_encode($errors);
        }

        $data = [
            "id_categoria" => $id_categoria,
            "nombre" => $nombre,
            "precio_entera" => $precio_entera, 
            "precio_media" => $precio_media
        ];

        if ($imagen = $this->request->getFile("imagen")) {

            $nombreImagen = $imagen->getName();
            $imagen->move(APPPATH . '../assets/img/platos', $nombreImagen);

            $data["imagen"] = $nombreImagen;
        }

        if ($mPlatos->updateRegistro($id_plato, $data))
        {
            $data["categoria"] = $mCat->obtenerRegistros(["id_categoria" => $id_categoria])["descripcion"];
            if (!isset($data["imagen"]))
                $data["imagen"] = $mPlatos->obtenerRegistros(["id_plato" => $id_plato])["imagen"];
            return json_encode($data);
        }
    }

    /**
     * Método ELIMINAR
     */

    public function delete()
    {
        $mPlatos = new M_Platos();

        $id_plato = $this->request->getPost("id_plato");
        $plato = $mPlatos->obtenerRegistros(["id_plato" => $id_plato]);

        if ($plato["imagen"] != "sin-imagen.png")
        {
            $ruta = realpath(APPPATH . '../assets/img/platos/' . $plato["imagen"]);
            unlink($ruta);
        }

        if (!$mPlatos->eliminaComandasConPlato($id_plato))
            return json_encode(["error" => "Error al eliminar la comanda"]);

        if (!$mPlatos->eliminaAlergenosPlato($id_plato))
            return json_encode(["error" => "Error al eliminar la comanda"]);

        if ($mPlatos->deleteRegistro($id_plato))
            return json_encode(["data" => "success"]);
    }

}