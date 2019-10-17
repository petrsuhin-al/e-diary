<?php

class Controller {
    public $model;
    public $mail;
    public function __construct($method="")
    {
        $model = new Model();
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $model->getSettings("SMTP_HOST");
        $mail->SMTPAuth = true;
        $mail->Username = $model->getSettings("SMTP_USER");
        $mail->Password = $model->getSettings("SMTP_PASSWORD");
        $mail->SMTPSecure = 'tls';
        $mail->From = $model->getSettings("SMTP_USER");
        $mail->FromName = $model->getSettings("MAIL_NAME");
        $mail->isHTML(true);
        $mail->CharSet = 'utf-8';
        $this->mail = $mail;


        $this->view = new View();
        $this->method = $method;


    }
    public function getVars()
    {
        
    }
    public function loadModel($name)
    {
        $path = 'models/' . $name . '_model.php';
        if (file_exists($path)) {
            require 'models/' . $name . '_model.php';
            $modelName = $name . '_model';
            $this->model = new $modelName();
            $this->model->mail = $this->mail;
        }
    }
    

}