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

        /* -- En esta parte muestro cómo hubiese sido el método si se hubiese llamado a la 
            API directamente -- */

        /*
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://local-business-data.p.rapidapi.com/business-reviews?business_id=0xd727be62b0bdea1%3A0x2dad48171be46d1f&limit=5&region=us&language=en",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "X-RapidAPI-Host: local-business-data.p.rapidapi.com",
                "X-RapidAPI-Key: 63f5b6c8e4msh91e0a3a760a1bf3p194b1bjsnc6c157702e3f"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo $response;
        }
        */
    }
}
