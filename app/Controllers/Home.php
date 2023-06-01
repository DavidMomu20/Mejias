<?php

namespace App\Controllers;

use App\Models\M_Habitaciones;
use App\Models\M_Usuarios;

class Home extends BaseController
{

    public function index()
    {
        if (session()->get('logged_in')) {

            if (session()->get("permisos_user")["perm7"] == 0)
                return redirect()->to(base_url("admin"));
            else {
                $data["reviews"] = $this->apiReviews();
                return view('mejias/index', $data);
            }
        }
        else {
            $data["reviews"] = $this->apiReviews();
            return view('mejias/index', $data);
        }
    }

    public function updateLang(?string $language = null)
    {
        $validLanguages = ['es', 'en', 'fr'];

        if (in_array($language, $validLanguages)) {
            session()->set('language', $language);

            
        }

        return redirect()->to(base_url());
    }

    public function reservarMesa()
    {
        $data["titulo"] = "Reserva de mesa";
        $data["cuerpo"] = view('mejias/reservamesa', $data);
        return view('template/plantilla', $data);
    }

    public function verHabitaciones()
    {
        $mHab = new M_Habitaciones();
        
        $data["habitaciones"] = $mHab->obtenerRegistros();
        $data["titulo"] = "Ver Habitaciones";
        $data["cuerpo"] = view('mejias/habitaciones', $data);
        return view('template/plantilla', $data);
    }

    public function miCuenta()
    {
        $mUser = new M_Usuarios();

        if (session()->get('logged_in'))
            $id = intval(session()->get('id_user'));

        $usuario = $mUser->buscaUsuarioById($id);

        $data["usuario"] = $usuario;
        $data["cuerpo"] = view("mejias/micuenta", $data);
        $data["titulo"] = "Mi cuenta";
        return view("template/plantilla", $data);
    }

    /**
     * -- FUNCIÓN API RESEÑAS --
     */

    private function apiReviews()
    {
        $jsonFile = ROOTPATH . 'assets/vendor/json/reviews.json';

        // Comprueba si el archivo existe
        if (file_exists($jsonFile)) {

            $jsonContent = file_get_contents($jsonFile);
            $allReviews = json_decode($jsonContent, true)["data"];

            $randomReviews = [];
            while (count($randomReviews) < 4) {
                $index = rand(0, count($allReviews) - 1);
                $selected = $allReviews[$index];

                if (!in_array($selected, $randomReviews) && $selected['rating'] >= 4) {
                    $randomReviews[] = $selected;
                }
            }

            return $randomReviews;
        } 
        else
            die('El archivo JSON no se encuentra.');
    }
}
