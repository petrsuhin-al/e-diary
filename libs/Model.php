<?php
class Model {
    public function __construct() {
         $this->db = new Database();
        $this->db->exec("set names utf8");
    }
    public function getRows($table,$id="",$cols="*"){
        if($id!="") $stmt = $this->db->query("SELECT $cols from $table WHERE id = $id");
        else $stmt = $this->db->query("SELECT $cols from $table");
        $obj = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $obj;
    }
    public function select($list,$id="",$GrID=""){
        switch ($list){
            case "groups":
                $sql = "SELECT groups.*, specialties.SpecName, teachers.TeachFIO, students.StudFIO 
                FROM groups,specialties,teachers, students
                WHERE groups.SpecID = specialties.id 
                      AND groups.CurID = teachers.id AND groups.StewID = students.id ";
                if($id!="") $sql .= "AND groups.id = $id ";
                $sql .= " ORDER BY groups.Course, specialties.specName, groups.grName";
                break;
            case "students":
                $sql = "SELECT students.*, groups.GrName, parents.ParFIO FROM students,groups,parents
                        WHERE groups.id = students.GrID AND parents.id = students.ParentID";
                if($id!="") $sql .= " AND students.id = $id";
                if($GrID!="") $sql .= " AND students.GrID = $GrID";
                $sql .= " ORDER BY groups.GrName, students.StudFIO";
                break;
            case "teachers":
                $sql = "SELECT teachers.* FROM teachers ";
                if($id!="") $sql .= "WHERE teachers.id = $id";
                $sql .= " ORDER BY teachers.TeachFIO";
                break;
            case "subjects":
                $sql = "SELECT subjects.* FROM subjects ";
                if($id!="") $sql .= "WHERE subjects.id = $id";
                $sql .= " ORDER BY subjects.SubjName";
                break;
            case "specialties":
                $sql = "SELECT specialties.* FROM specialties ";
                if($id!="") $sql .= "WHERE specialties.id = $id";
                $sql .= " ORDER BY specialties.SpecCode, specialties.SpecName";
                break;
            case "parents":
                $sql = "SELECT parents.* FROM parents ";
                if($id!="") $sql .= "WHERE parents.id = $id";
                $sql .= " ORDER BY parents.ParFIO";
                break;

        }
        $result = $this->db->query($sql);
        $arr =  $result->fetchAll(PDO::FETCH_OBJ);
        return $arr;

    }
    public function getSettings($attr){
        $result = $this->db->query("SELECT Value FROM settings WHERE Attribute = '$attr'");
        return $result->fetchObject()->Value;
    }
    public function getSmallFIO($FIO){
        $FIO = explode(" ", $FIO);
        return $FIO[0]." ".mb_substr($FIO[1],0,1).".".mb_substr($FIO[2],0,1).".";
    }
    public function getLogin($FIO)
    {
        $FIO = explode(" ", $FIO);
        return $rest = $this->transliterate($FIO[0]).rand(1000,10000);
    }
    public function getPassword($FIO){
        $FIO = explode(" ", $FIO);
        return $rest = $this->transliterate($FIO[0]).rand(1000, 10000);
    }
    public function transliterate($input)
    {
        $array = array(
            "Є"=>"YE","І"=>"I","Ѓ"=>"G","і"=>"i","№"=>"-","є"=>"ye","ѓ"=>"g",
            "А"=>"A","Б"=>"B","В"=>"V","Г"=>"G","Д"=>"D",
            "Е"=>"E","Ё"=>"YO","Ж"=>"ZH",
            "З"=>"Z","И"=>"I","Й"=>"J","К"=>"K","Л"=>"L",
            "М"=>"M","Н"=>"N","О"=>"O","П"=>"P","Р"=>"R",
            "С"=>"S","Т"=>"T","У"=>"U","Ф"=>"F","Х"=>"X",
            "Ц"=>"C","Ч"=>"CH","Ш"=>"SH","Щ"=>"SHH","Ъ"=>"'",
            "Ы"=>"Y","Ь"=>"","Э"=>"E","Ю"=>"YU","Я"=>"YA",
            "а"=>"a","б"=>"b","в"=>"v","г"=>"g","д"=>"d",
            "е"=>"e","ё"=>"yo","ж"=>"zh",
            "з"=>"z","и"=>"i","й"=>"j","к"=>"k","л"=>"l",
            "м"=>"m","н"=>"n","о"=>"o","п"=>"p","р"=>"r",
            "с"=>"s","т"=>"t","у"=>"u","ф"=>"f","х"=>"x",
            "ц"=>"c","ч"=>"ch","ш"=>"sh","щ"=>"shh","ъ"=>"",
            "ы"=>"y","ь"=>"","э"=>"e","ю"=>"yu","я"=>"ya",
            " "=>"_","—"=>"_",","=>"_","!"=>"_","@"=>"_",
            "#"=>"-","$"=>"","%"=>"","^"=>"","&"=>"","*"=>"",
            "("=>"",")"=>"","+"=>"","="=>"",";"=>"",":"=>"",
            "~"=>"","`"=>"","?"=>"","/"=>"");
        return strtr($input, $array);
    }
    public function getReal($userID){
        $result = $this->db->query("SELECT *, StudFIO as FIO FROM students WHERE UserID = $userID");
        if($result->rowCount()==1) {
            Session::set("role","student");
            return $result;
        }
        $result = $this->db->query("SELECT *, TeachFIO as FIO FROM teachers WHERE UserID = $userID");
        if($result->rowCount()==1){
            Session::set("role","teacher");
            return $result;
        }
        $result = $this->db->query("SELECT *, ParFIO as FIO FROM parents WHERE UserID = $userID");
        if($result->rowCount()==1) {
            Session::set("role","parent");
            return $result;
        }
    }
    
}