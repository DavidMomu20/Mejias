<?php

namespace App\Libraries;

class EmailsSender
{

  public function SendEmails($data = [])
  {
    # Inicializamos el servicio de envío de mails de CI4
    $email = \Config\Services::email();

    $email->setTo( $data['emailTO']);
   //$email->setCC( $data['emailCC']);
    //$email->setBCC( $data['emailBCC']);

    $email->setSubject( $data['subject']);
    $email->setMessage( $data['message']);

    if ($email->send())
    {
        return (true);
    }
    else
    {
      $pathLogs = dirname(dirname(dirname( __FILE__)))  . "/writable/logs/";

      $data_error = $email->printDebugger(['headers']);

      error_log( date("Y-m-d H:i:s") . " - " . json_encode( $data, true) . "\n", 3, $pathLogs."email_error.log");
      error_log( date("Y-m-d H:i:s") . " - " . print_r( $data_error, true) . "\n", 3, $pathLogs."email_error.log");

      return (false);
    }
  }
}

?>