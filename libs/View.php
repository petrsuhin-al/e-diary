<?php
class View {
    public $msg;
    public function __construct() {
    }

    public function render($name, $noInclude = false) {
        Session::init();
            if(Session::get('loggedIn') == true){
                if($noInclude == true) {
                    require 'views/'.$name.'_view.php';
                } else {
                    require 'views/header.php';
                    require 'views/' . $name . '_view.php';
                    require 'views/footer.php';
                }
            } else{
                require 'views/header.php';
                require 'views/login_view.php';
            }

        }
}