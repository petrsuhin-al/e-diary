<?php
class Dashboard_Model extends Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function chPassSubmit($type="update"){
        $id = Session::get('logId');

        if(!isset($_POST['old'])) $old = "";
        else $old = md5($_POST['old']);
        if(!isset($_POST['password'])) $password = "";
        else $password = md5($_POST['password']);
        $result = $this->db->query("SELECT password FROM users WHERE UserID = $id");
        $check = false;
        if($result->fetchAll()[0]['password']==$old){
            $check = true;
        }
        if($check){
            if($type!="watch")
            $this->db->query("UPDATE users SET password = '$password' WHERE UserID = $id");
            return "good";
        }
        else return "Не правильно введён старый пароль";
    }

}