<?php
class Login extends Controller {
    public function __construct()
    {
        parent::__construct();
        
    }

    public function index()
    {
        $this->view->logo = $this->model->getSettings("CollegeLogo");
        if(Session::get("loggedIn")==true) header('Location: '.URL);
        $this->view->render('login');
    }

    public function run()
    {
        $this->model->run();
    }
}