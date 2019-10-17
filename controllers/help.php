<?php
class Help extends Controller{
    public function __construct()
    {
        parent::__construct();

    }
    public function index()
    {
        $this->view->render('help');
    }
    public function other($arg = false) {
        echo "Мы в методе other контроллера Help";
        echo "Параметры: ".$arg;
        //require 'models/lists_model.php';
    }

}