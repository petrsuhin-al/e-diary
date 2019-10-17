<?php
class Database extends PDO
{
    public function __construct() {
        try {
            parent::__construct('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . '', '' . DB_USER . '', '' . DB_PASS . '');
            $res = $this->query("SHOW TABLES");
            if($res->rowCount()==0){
                header('Location: http://'.$_SERVER['SERVER_NAME'].'/install.php');
            }
        }
        catch (PDOException $er){
        header('Location: http://'.$_SERVER['SERVER_NAME'].'/install.php');
        }
    }
}