<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Agrega esta línea

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = [];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        $session = \Config\Services::session();
        $language = \Config\Services::language();
        $language->setLocale($session->lang);

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = \Config\Services::session();
    }

    /**
     * Método para enviar email
     */

    public function enviarEmail(array $datos)
    {
        // Crea una instancia de PHPMailer
        $mail = new PHPMailer(true);

        try {
            // Configuración del servidor de correo
            $mail->isSMTP();
            $mail->Host       = 'sandbox.smtp.mailtrap.io';  // Cambia por tu servidor SMTP
            $mail->SMTPAuth   = true;
            $mail->Username   = '08fd788cd37fcb';  // Cambia por tu dirección de correo
            $mail->Password   = '927b6721542ff2';  // Cambia por tu contraseña
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  // Opcionalmente cambia a ENCRYPTION_SMTPS para SMTPS
            $mail->Port       = 2525;  // Cambia por el puerto de tu servidor SMTP

            // Configuración del mensaje
            $mail->setFrom('davidmoralesm2003@hotmail.com', 'David Morales');
            $mail->addAddress("davidmomu4@gmail.com", $datos["usuario"]);
            $mail->Subject = $datos["asunto"];
            $mail->Body = $datos["body"];
            
            // Envía el correo electrónico
            $mail->send();

            return json_encode(["data" => 'Correo enviado correctamente.']);
        } catch (Exception $e) {
            return json_encode(["data" => 'Error al enviar el correo: ' . $mail->ErrorInfo]);
        }
    }
}
