<?php

namespace App\Controllers;

use App\Models\M_Habitaciones;

class Home extends BaseController
{

    public function index()
    {
        if (session()->get('logged_in')) {

            if (session()->get("permisos_user")["perm7"] == 0)
                return redirect()->to(base_url("admin"));
            else
                return view('mejias/index');
        }
        else
            return view('mejias/index');
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
}
