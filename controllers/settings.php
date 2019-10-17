<?php

class Settings extends Controller {
    // ...
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if(Session::get("role")=="admin") {
            $this->view->CollegeName = $this->model->getAttributes("CollegeName");
            $this->view->URL = $this->model->getAttributes("URL");
            $this->view->SMTP_HOST = $this->model->getAttributes("SMTP_HOST");
            $this->view->SMTP_USER = $this->model->getAttributes("SMTP_USER");
            $this->view->SMTP_PASSWORD = $this->model->getAttributes("SMTP_PASSWORD");
            $this->view->MAIL_NAME = $this->model->getAttributes("MAIL_NAME");
            $this->view->CollegeLogo = $this->model->getAttributes("CollegeLogo");
            $this->view->render('settings');
        }else header('Location: '.URL);

    }

    public function save(){
        $this->model->save();
    }
}