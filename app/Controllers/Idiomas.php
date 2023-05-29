<?php 
namespace App\Controllers;

use CodeIgniter\Controller;

class Idiomas extends Controller{

    public function cambiaIdioma($language)
    {
        $session = session();
        $session->set('language', $language);
        return redirect()->back();
    }
}