<?php

class Dashboard extends Controller {
    // ...
    public function __construct()
    {
        parent::__construct();
        $logged = Session::get('loggedIn');
        if($logged == false) {
            Session::destroy();
            header('Location: ../login');
            exit();
        }
    }

    public function index()
    {
        header('Location: '.URL);
    }

    public function changePass(){
        $this->view->changePass= true;
        $this->view->render("dashboard");
    }

    public function chPassSubmit(){
        if($this->model->chPassSubmit("watch")=="good"){
            $this->model->chPassSubmit();
            header('Location: /dashboard/changePass/?good');
        }
        else
        header('Location: /dashboard/changePass/?trouble');
    }
    public function logout() {
        Session::destroy();
        header('Location: /login');
        exit();
    }
}