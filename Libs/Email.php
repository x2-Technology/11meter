<?php

/**
 * Created by PhpStorm.
 * User: adler_supervisor
 * Date: 16.08.17
 * Time: 14:08
 * Developer:Süleyman Topaloglu
 */
class Email
{

      function __construct($pars = null)
      {

      }
      
      
      public function send($from = "noreply@iroc.com", $receiver = "", $subject = "", $message = "Welcome to Iroc", $reply = "No-Reply", $functionID = "")
      {
            
            $params = array(
                "from" => $from,
                "receiver" => $receiver,
                "subject" => $subject,
                "message" => $message,
                "reply" => $reply
            );
            
            
            // $params = array_merge( $defaults, $params );
            
            $to = $params["receiver"];
            $subject = $params["subject"];
            $message = $params["message"];// . $params["from"];
            
            $message .= !empty($functionID) ? " Mail ID:{$functionID}" : "";
            
            
            $header = $this->mailHeader($params["from"], $params["reply"]);
            
            $resulta = mail($to, $subject, $message, $header);
            
            if ($resulta) {
                  $resulta = true;
                  $errMessage = "";
            } else {
                  $resulta = false;
                  $errMessage = error_get_last();
            }
            
            return array("resulta" => $resulta, "errMessage" => $errMessage, "params" => $params);



            
      }
      
      private function mailHeader($from, $reply)
      {
            
            $header = "From: $from" . "\r\n" .
                "Reply-To: {$reply}" . "\r\n" .
                "X-Mailer: PHP/" . phpversion() . "\r\n" .
                "MIME-Version: 1.0" . "\r\n" .
                "Content-type: text/html;charset:utf-8\r\n\r\n";
            
            return $header;
      }
      
      
}