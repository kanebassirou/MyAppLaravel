<?php
namespace App\Services;
use PHPMailer\PHPMailer\PHPMailer;

class EmailService {
    protected $app_name;
    protected $username;
    protected $password;
    protected $port;
    protected $host;
    
    public function __construct()
    {
        $this->app_name = config('app.name');      
        $this->host = config('app.email_host');      
        $this->port = config('app.email_port');      
        $this->username = config('app.email_username');      
        $this->password = config('app.email_password');      
    }
    
    public function sendEmail($subject, $emailUser, $nameUser, $ishtml, $message)
    {
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->SMTPDebug = 0; // Utilisez 0 pour désactiver le mode débogage ou 2 pour un débogage détaillé
        $mail->Host = $this->host;
        $mail->Port = $this->port;
        $mail->Username = $this->username;
        $mail->Password = $this->password;
        $mail->SMTPAuth = true;
        $mail->Subject = $subject;
        $mail->setFrom($this->app_name, $this->app_name);
        $mail->addReplyTo($this->app_name, $this->app_name);
        $mail->addAddress($emailUser, $nameUser);
        $mail->isHTML($ishtml);
        $mail->Body = $message;
        $mail->send();
    }
}
