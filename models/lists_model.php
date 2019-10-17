<?php
class Lists_Model extends Model
{
    public function __construct()
    {
        parent::__construct();
        //echo 'Модель lists_model';
    }
    

    public function confirmAdd($arg)
    {
        $mail = $this->mail;

        switch ($arg){
            case "groups":
                $sth = $this->db->prepare("INSERT INTO groups(GrName, Course, SpecID, CurID, StewID) 
                                           VALUES (:GrName,:Course,:SpecID,:CurID,:StewID)");
                $sth->execute(array(
                    ':GrName' => $_POST['GrName'],
                    ':Course' => $_POST['Course'],
                    ':SpecID' => $_POST['SpecID'],
                    ':CurID' => $_POST['CurID'],
                    ':StewID' => $_POST['StewID']
                ));
                break;
            case "students":
                $password = $this->getPassword($_POST['StudFIO']);
                $md5pass = md5($password);
                $sth = $this->db->prepare("INSERT INTO users(login, password, Email,Admin) 
                          VALUES (:Email,:password,:Email, 0)");
                $sth->execute(array(
                    ':password' => $md5pass,
                    ':Email' => $_POST['Email']
                ));
                $id = $this->db->lastInsertId();

                $sth = $this->db->prepare("INSERT INTO students(StudFIO, GrID, ParentID,UserID) 
                          VALUES (:StudFIO,:GrID,:ParentID,:id)");
                $sth->execute(array(
                ':StudFIO' => $_POST['StudFIO'],
                ':GrID' => $_POST['GrID'],
                ':ParentID' => $_POST['ParentID'],
                    ':id' => $id
                 ));



                $mail->addAddress($_POST['Email']);
                $mail->Subject = 'Регистрация в электронном журнале';
                $mail->Body    = '<h2>Приветствуем вас, '.$_POST['StudFIO'].'!</h2>
                <p>Вы были зарегестрированы в сервисе - "электронный журнал" как <b>студент</b>.</p>
                <p> Ваш логин для доступа - '.$_POST['Email'].'</p>
                <p> Ваш пароль для доступа - '.$password.'</p>
                <p><a href="'.URL.'">Перейти в систему</a></p>';
                $mail->send();

                break;

            case "parents":
                $password = $this->getPassword($_POST['ParentFIO']);
                $md5pass = md5($password);
                $sth = $this->db->prepare("INSERT INTO users(login, password,Email,Admin) 
                          VALUES (:Email,:password,:Email, 0)");
                $sth->execute(array(
                    ':password' => $md5pass,
                    ':Email' => $_POST['Email']
                ));
                $id = $this->db->lastInsertId();

                $sth = $this->db->prepare("INSERT INTO parents(ParFIO,UserID) 
                          VALUES (:ParFIO,:id)");
                $sth->execute(array(
                    ':ParFIO' => $_POST['ParentFIO'],
                    ':id' => $id
                ));

                $id = $this->db->lastInsertId();
                foreach ($_POST['childs'] as $child){
                    $this->db->query("UPDATE students SET ParentID=$id WHERE id=$child");
                }

                $mail->addAddress($_POST['Email']);
                $mail->Subject = 'Регистрация в электронном журнале';
                $mail->Body    = '<h2>Приветствуем вас, '.$_POST['ParentFIO'].'!</h2>
                <p>Вы были зарегестрированы в сервисе - "электронный журнал" как <b>родитель</b>.</p>
                <p> Ваш логин для доступа - '.$_POST['Email'].'</p>
                <p> Ваш пароль для доступа - '.$password.'</p>
                <p><a href="'.URL.'">Перейти в систему</a></p>';
                $mail->send();

                break;

            case "teachers":
                $password = $this->getPassword($_POST['TeachFIO']);
                $md5pass = md5($password);
                $sth = $this->db->prepare("INSERT INTO users(login, password, Email,Admin) 
                          VALUES (:login,:password,:Email,0)");
                $sth->execute(array(
                    ':login' => $_POST['Email'],
                    ':password' => $md5pass,
                    ':Email' => $_POST['Email']
                ));
                $id = $this->db->lastInsertId();
                $sth = $this->db->prepare("INSERT INTO teachers(TeachFIO,UserID) VALUES (:TeachFIO,:id)");
                $sth->execute(array(
                   ':TeachFIO' => $_POST['TeachFIO'],
                    ':id' => $id
                ));
                $id = $this->db->lastInsertId();
                foreach ($_POST['subjects'] as $subject){
                    $this->db->query("INSERT INTO teachers_subjects(TeachID, SubjID) VALUES ($id,$subject)");
                }

                $mail->addAddress($_POST['Email']);
                $mail->Subject = 'Регистрация в электронном журнале';
                $mail->Body    = '<h2>Приветствуем вас, '.$_POST['TeachFIO'].'!</h2>
                <p>Вы были зарегестрированы в сервисе - "электронный журнал" как <b>преподаватель</b>.</p>
                <p> Ваш логин для доступа - '.$_POST['Email'].'</p>
                <p> Ваш пароль для доступа - '.$password.'</p>
                <p><a href="'.URL.'">Перейти в систему</a></p>';
                $mail->send();

                break;
            case "subjects":
                $sth = $this->db->prepare("INSERT INTO subjects(SubjName) VALUES (:SubjName)");
                $sth->execute(array(
                   ':SubjName' => $_POST['SubjName']
                ));

                break;
            case "specialties":
                $sth = $this->db->prepare("INSERT INTO specialties(SpecName,SpecCode)VALUES (:SpecName,:SpecCode)");
                $sth->execute(array(
                   ':SpecName' => $_POST['SpecName'],
                    ':SpecCode' => $_POST['SpecCode']
                ));
                break;
        }
        

    }
    public function selectSubjects($id,$table){
        if($table=="teachers") $result = $this->db->query("SELECT SubjID FROM teachers_subjects WHERE TeachID='$id'");
        else if($table=="groups") $result = $this->db->query("SELECT SubjID FROM groups_subjects WHERE GroupID='$id'");
        $arr =  $result->fetchAll(PDO::FETCH_OBJ);
        return $arr;
    }
    public function confirmEdit($arg,$id="")
    {
        $arg = explode(".",$arg);
        $id = $arg[1];
        $arg = $arg[0];
        switch ($arg){
            case "groups":
                $sth = $this->db->prepare("UPDATE groups SET 
                                           GrName = :GrName,Course = :Course,
                                           SpecID = :SpecID,CurID = :CurID, StewID = :StewID
                                           WHERE id = :id");
                $sth->execute(array(
                    ':GrName' => $_POST['GrName'],
                    ':Course' => $_POST['Course'],
                    ':SpecID' => $_POST['SpecID'],
                    ':CurID' => $_POST['CurID'],
                    ':StewID' => $_POST['StewID'],
                    ':id' => $id
                ));

                break;
            case "students":
                $sth = $this->db->prepare("UPDATE students SET 
                                           StudFIO = :StudFIO, GrID = :GrID, ParentID = :ParentID
                                            WHERE id = :id");
                $sth->execute(array(
                    ':StudFIO' => $_POST['StudFIO'],
                    ':GrID' => $_POST['GrID'],
                    ':ParentID' => $_POST['ParentID'],
                    ':id' => $id
                ));
                break;
            case "teachers":
                $sth = $this->db->prepare("UPDATE teachers SET TeachFIO = :TeachFIO WHERE id = :id");
                $sth->execute(array(
                    ':TeachFIO' => $_POST['TeachFIO'],
                    ':id' => $id
                ));
                $res = $this->db->query("SELECT * FROM teachers_subjects WHERE TeachID=$id");
                $objects = $res->fetchAll(PDO::FETCH_OBJ);
                if(isset($_POST['subjects'])){
                    foreach ($_POST['subjects'] as $subject){
                        $check = false;
                        foreach ($objects as $obj){
                            if ($obj->SubjID == $subject) $check = true;
                        }
                        if($check==false) $this->db->query("INSERT INTO teachers_subjects(TeachID, SubjID) VALUES ($id,$subject)");
                    }
                    if(count($_POST['subjects'])<count($objects)){
                        foreach($objects as $obj){
                        $check = false;
                            foreach ($_POST['subjects'] as $subject){
                                if($subject == $obj->SubjID){ $check = true; break;}
                            }
                        if($check==false) $this->db->query("DELETE FROM teachers_subjects WHERE TeachID = $id AND SubjID = $obj->SubjID");
                        }
                    }
                    $res = $this->db->query("SELECT * FROM groups_subjects WHERE TeachID=$id");
                    $objects = $res->fetchAll(PDO::FETCH_OBJ);
                        foreach($objects as $obj){
                            $check = false;
                            foreach ($_POST['subjects'] as $subject){
                                if($subject == $obj->SubjID){ $check = true; break;}
                            }
                            if($check==false) $this->db->query("UPDATE groups_subjects SET TeachID = 1 WHERE TeachID = $id AND SubjID = $obj->SubjID");
                        }

                }
                else{
                    if(count($objects)>0){
                        $this->db->query("DELETE FROM teachers_subjects WHERE TeachID = $id");
                        $this->db->query("UPDATE groups_subjects SET TeachID = 1 WHERE TeachID = $id");
                    }
                }
                break;
            case "parents":
                $sth = $this->db->prepare("UPDATE parents SET ParFIO = :ParFIO WHERE id = :id");
                $sth->execute(array(
                    ':ParFIO' => $_POST['ParentFIO'],
                    ':id' => $id
                ));
                if(isset($_POST['childs'])){
                    foreach ($_POST['childs'] as $child){
                        $this->db->query("UPDATE students SET ParentID=$id WHERE id=$child");
                    }
                    $res = $this->db->query("SELECT * FROM students WHERE ParentID=$id");
                    $students = $res->fetchAll(PDO::FETCH_OBJ);
                    foreach ($students as $student){
                        $check = false;
                        foreach ($_POST['childs'] as $child){
                            if($child==$student->id){ $check=true; break;}
                        }
                        if(!$check) $this->db->query("UPDATE students SET ParentID=1 WHERE id=$student->id");
                    }
                }
                else $this->db->query("UPDATE students SET ParentID=1 WHERE ParentID = $id");

                break;
            case "subjects":
                $sth = $this->db->prepare("UPDATE subjects SET SubjName= :SubjName WHERE id = :id");
                $sth->execute(array(
                    ':SubjName' => $_POST['SubjName'],
                    ':id' => $id
                ));
                break;
            case "specialties":
                $sth = $this->db->prepare("UPDATE specialties SET SpecName = :SpecName, SpecCode = :SpecCode
                                            WHERE id = :id");
                $sth->execute(array(
                    ':SpecName' => $_POST['SpecName'],
                    ':SpecCode' => $_POST['SpecCode'],
                    'id' => $id
                ));
                break;
        }
        

    }
    function info($args){
        $type = explode(".",$args)[0];
        $id = explode(".",$args)[1];
        switch ($type){
            case "groups":
                $sql = "SELECT groups.Course, groups.GrName, teachers.TeachFIO, students.StudFIO,  specialties.SpecName, specialties.SpecCode
                         FROM groups
                         INNER JOIN students ON students.id = groups.StewID
                         INNER JOIN teachers ON teachers.id = groups.CurID
                         INNER JOIN specialties ON specialties.id = groups.SpecID
                         WHERE groups.id=$id";
                $result1 = $this->db->query($sql);
                $result2 = $this->db->query("SELECT *, students.id As StudID FROM students INNER JOIN parents ON students.ParentID = parents.id
                                             WHERE students.GrID = $id");
                $StewID = $this->db->query("SELECT StewID FROM groups WHERE id = $id");
                $arr[0] = $result1->fetchObject();
                $arr[1] = $result2->fetchAll(PDO::FETCH_OBJ);
                $arr[2] = $StewID->fetchObject()->StewID;
                return $arr;
            case "students":
                $sql = "SELECT students.StudFIO, groups.GrName, parents.ParFIO FROM students
                        INNER JOIN groups ON groups.id = students.GrID
                        INNER JOIN parents ON parents.id = students.ParentID
                        WHERE students.id = $id";
                $result1 = $this->db->query($sql);
                $sql2 = "SELECT subjects.SubjName, AVG(marks.Mark) As AvgMark FROM subjects
                         INNER JOIN (students 
                         INNER JOIN (lessons 
                         INNER JOIN marks ON lessons.LessonID = marks.LessonID) ON students.id = marks.StudID) ON subjects.id = lessons.SubjID
                         WHERE marks.Mark <> 0
                         GROUP BY subjects.SubjName, students.id
                         HAVING students.id = $id";
                $result2 = $this->db->query($sql2);
                $abs = array("н","б","п");
                for($i=0; $i<3; $i++){
                    $sql = "SELECT subjects.SubjName, COUNT(marks.Absent) As AvgMark FROM subjects
                         INNER JOIN (students 
                         INNER JOIN (lessons 
                         INNER JOIN marks ON lessons.LessonID = marks.LessonID) ON students.id = marks.StudID) ON subjects.id = lessons.SubjID
                         WHERE marks.Absent = '{$abs[$i]}'
                         GROUP BY subjects.SubjName, students.id
                         HAVING students.id = $id";
                    $arr[$i+2] = $this->db->query($sql)->fetchAll(PDO::FETCH_OBJ);
                }
                $result3 = $this->db->query("SELECT subjects.SubjName, COUNT(marks.Absent) As AvgMark FROM subjects
                         INNER JOIN (students 
                         INNER JOIN (lessons 
                         INNER JOIN marks ON lessons.LessonID = marks.LessonID) ON students.id = marks.StudID) ON subjects.id = lessons.SubjID
                         GROUP BY subjects.SubjName, students.id
                         HAVING students.id = $id");
                $arr[5] = $result3->fetchAll(PDO::FETCH_OBJ);
                $arr[0] = $result1->fetchObject();
                $arr[1] = $result2->fetchAll(PDO::FETCH_OBJ);
                return $arr;
            case "teachers":
                $sql = "SELECT TeachFIO FROM teachers WHERE id = $id";
                $result1 = $this->db->query($sql);
                $arr[0] = $result1->fetchObject();
                return $arr;
        }

    }
    function del($arg)
    {
        try
        {
        $sth = $this->db->prepare("DELETE FROM $arg[0] WHERE id = :id");
        $sth->execute(array(
                    ':id' => $arg[1]
        ));
        }
        catch (PDOException $e){
            die("Error: ".$e->getMessage());
        }
       
        
        //if($arg[0]=="students")
    }


}
