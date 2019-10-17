<?php
class Login_Model extends Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function run() {
        $sth = $this->db->prepare("SELECT * FROM users WHERE login = :login AND password = :password");
        $sth->execute(array(
            ':login' => $_POST['login'],
            ':password' => md5($_POST['password'])
        ));
        
        $row = $sth->fetch(PDO::FETCH_ASSOC);
        $count = $sth->rowCount();
        if($count > 0) {
            Session::init();
            Session::set('loggedIn', true);
            Session::set('logId',$row['UserID']);
            if($row['Admin']>=1) Session::set('role','admin');
            header('Location: '.URL.'');
        } else {
            header('Location: '.URL.'login');
        }
    }

}